<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try{
            $googleUser = Socialite::driver('google')->user();

            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if (!$existingUser) {
                // Generate a unique username
                $baseUsername = Str::slug($googleUser->getName(), '_'); // Slugify the name
                $username = $this->generateUniqueUsername($baseUsername);

                // Create the user
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'username' => $username,
                    'password' => null,
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                ]);

                auth()->login($newUser);

                return redirect()->route('home')->with('success', 'Account created successfully.');
            }

            if($existingUser->google_id != $googleUser->getId() || $existingUser->google_id == null) {
                $existingUser->update([
                    'google_id' => $googleUser->getId(),
                ]);
            }

            auth()->login($existingUser);
            return redirect()->route('home')->with('success', 'Logged in successfully.');

        }catch (\Exception $exception){
            $responseBody = json_decode($exception->getResponse()->getBody()->getContents());
            return redirect()->route('login')->withErrors(["externalValidationError"=>$responseBody]);
        }
    }

    private function generateUniqueUsername($baseName)
    {
        // Step 1: Clean the base name
        $baseName = trim($baseName);
        $nameParts = preg_split('/\s+/', $baseName); // Split by spaces

        // Handle single or multiple name parts
        if (count($nameParts) >= 2) {
            $cleanBaseName = Str::slug($nameParts[0] . '_' . $nameParts[count($nameParts) - 1], '_'); // First + Last
        } else {
            $cleanBaseName = Str::slug($nameParts[0], '_'); // Use the single name
        }

        // Step 2: Generate a short UUID
        $shortUuid = substr(Str::uuid()->toString(), 0, 8);

        // Step 3: Get a unique incremental number (based on current user count or max ID)
        $userCount = User::count();  // Total number of users
        $randomSeed = rand(100, 999); // Small random number for variability
        $randomSuffix = ($userCount * 7 + $randomSeed) % 10000;

        // Step 4: Combine everything into the username
        $username = "{$cleanBaseName}_{$shortUuid}_{$randomSuffix}";

        // Step 5: Ensure uniqueness
        while (User::where('username', $username)->exists()) {
            $username = "{$cleanBaseName}_{$shortUuid}_{$randomSuffix}";
        }

        return $username;
    }


}
