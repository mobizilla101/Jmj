<?php

namespace App\Livewire;

use App\Services\ChatGPT;
use Livewire\Component;

class AiChat extends Component
{
    private ?ChatGPT $chat = null; // Allow null initialization

    public array $messages = [];

    public string $message = '';

    public ?string $error = null;

    private array $inititalMessage = [
        "role" => "assistant",
        "content" => "Hello! How can I assist you today?"
    ];

    // Lazy initializer for the ChatGPT instance
    private function getChat()
    {
        try {
            // setting up what to say in initial setup without sending data to chatgpt.
            if (!$this->chat) {
                $this->chat = new ChatGPT($this->inititalMessage);
                $chatHistory = $this->chat->getChat();
                $this->messages = !empty($chatHistory)?$chatHistory:[$this->inititalMessage];
            }
            return $this->chat;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            return null;
        }
    }

    public function mount()
    {
        $this->getChat();

        if ($this->error) {
            $this->messages[] = [
                "role" => "assistant",
                "content" => "Sorry, the chat service is currently unavailable. Please try again later."
            ];
        }
    }

    public function render()
    {
        return view('livewire.ai-chat');
    }

    private function setUserMessage(string $message){
        $this->messages[] = [
            'role' => 'user',
            'content' => $message
        ];
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function sendMessage($message)
    {
        if (trim($message) === '') {
            $this->skipRender();
            $message = [
                "role" => "assistant",
                'content' => "Sorry, message cannot be empty."
            ];
            return [
                "success"=>false,
                "message"=>$message
            ];
        }


        if (strlen($message) > 500) {
            $message = [
                "role" => "system",
                "content" => "Message is too long. Please limit your input to 500 characters."
            ];
            $this->messages[] = $message;
            $this->skipRender();
            return [
                "success"=>false,
                "message"=>$message
            ];
        }

        if ($this->error) {
            $message = [
                "role" => "system",
                "content" => "Unable to send your message. The chat service is unavailable: {$this->error}"
            ];
            $this->messages[] = $message;
            $this->skipRender();
            return [
                "success"=>false,
                "message"=>$message
            ];
        }

        try {
            $response = $this->getChat()->sendMessage($message);

            $this->setUserMessage($message);

            $res = [
                "role"=>$response['message']['role'],
                'content'=>$response['message']['content']
            ];

            $this->messages[] = $res;
            $this->getChat()->saveChat($this->messages);
            $this->skipRender();
            return [
                "success"=>true,
                "message"=>$res
            ];

        } catch (\Exception $e) {
            $message = [
                "role" => "assistant",
                "content" => "An error occurred: " . $e->getMessage()
            ];

            $this->messages[] = $message;
            $this->skipRender();
            return [
                "success"=>false,
                "message"=>$message
            ];
        }
    }

    public function resetChat(){
        $this->getChat()->resetChat();
    }
}
