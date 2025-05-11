<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Mockery\Exception;

class ChatGPT
{
    private $client;
    private $apiKey;
    private $openAiUrl;

    private $model;

    private string|null $sessionKey = null;
    private int|null $expirationMinutes = null;
    private array $chatHistroy = [
        [
            'role' => "system",
            'content' => "You are to help user with their inquires about mobizilla and as a mobizilla assistance welcome them first. help them with pricing and mobile information with broken parts and all"
        ]
    ];

    public function __construct(array $initialReply = [])
    {
        $chatHistory = $this->getChat();
        if (!empty($chatHistory)) {
            $this->chatHistroy = $chatHistory;
        } else {
            if (!empty($initialReply)) {
                $this->chatHistroy[] = $initialReply;
            }
        }

        $this->client = new Client();
        $this->model = config('chatgpt.model');
        $this->apiKey = config('chatgpt.key');
        $this->openAiUrl = config('chatgpt.url');
        $this->sessionKey = config('chatgpt.sessionKey');
        $this->expirationMinutes = config('chatgpt.sessionExpirationMinutes');

        $this->validateConfiguration();
    }

    private function validateConfiguration()
    {
        if (!$this->apiKey && !$this->model && !$this->openAiUrl) {
            return throw new Exception('Ai chat is not configured');
        }
        return true;
    }

    public function sendMessage($message, $role = "user", $model = null): array
    {

        $this->validateConfiguration();
        try {
            $this->chatHistroy[] = [
                'role' => $role,
                'content' => $message
            ];

            if (count($this->chatHistroy) > 10) {
                $this->chatHistroy = array_slice($this->chatHistroy, -10);
            }

            $modelToUse = $model ?? $this->model;

            $response = $this->client->post($this->openAiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $modelToUse,
                    'messages' => $this->chatHistroy,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['choices'][0])) {
                return $data['choices'][0];
            }

            throw new \Exception('Unexpected API response format.');

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
                if (isset($errorResponse['error'])) {
                    throw new \Exception($errorResponse['error']['message']);
                }
            }

            // Handle cases where no response body is available
            throw new \Exception('API Request Failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Handle general exceptions
            throw new \Exception('An error occurred: ' . $e->getMessage());
        }
    }

    public function saveChat(array $messages)
    {
        // Trim to the last 10 messages before saving
        $trimmedMessages = array_slice($messages, -10);

        session()->put($this->sessionKey, $trimmedMessages);
        session()->put($this->sessionKey . '_active', now());
    }

    public function getChat(): array
    {
        if (session()->has($this->sessionKey . '_active')) {
            $lastActive = session()->get($this->sessionKey . '_active');
            if ($lastActive && now()->diffInMinutes($lastActive) >= $this->expirationMinutes) {
                // Clear expired session
                session()->forget($this->sessionKey);
                session()->forget($this->sessionKey . '_active');
                return [];
            }
            return session()->get($this->sessionKey, []);
        }
        return [];
    }

    public function resetChat(){
        session()->forget($this->sessionKey);
        session()->forget($this->sessionKey . '_active');
    }
}
