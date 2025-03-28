<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp;
use Auth;

use App\Models\User;

class DiscordController extends Controller
{
    protected $tokenURL = "https://discord.com/api/oauth2/token";
    protected $apiURLBase = "https://discord.com/api/users/@me";

    // Login function
    public function login(){
        return redirect(env("DISCORD_URL"));
    }

    // Callback function
    public function callback(Request $request) {
        if (Auth::check()) {return redirect()->route("index");};
        if ($request->missing("code") && $request->missing("access_token")) {return redirect()->route("index");};
        $tokenData = [
            "client_id" => env("DISCORD_CLIENT"),
            "client_secret" => env("DISCORD_SECRET"),
            "grant_type" => "authorization_code",
            "code" => NULL,
            "redirect_uri" => env("DISCORD_CALLBACK"),
            "scope" => "identifiy&guilds&email"
        ];

        $tokenData["code"] = $request->get("code");

        $client = new GuzzleHttp\Client();
        
        try {
            $accessTokenData = $client->post($this->tokenURL, ["form_params" => $tokenData]);
            $accessTokenData = json_decode($accessTokenData->getBody());   
        } catch (\GuzzleHttp\Exception\ClientException $error) {
            return redirect()->route("index");
        };

        $userData = Http::withToken($accessTokenData->access_token)->get($this->apiURLBase);
        if ($userData->clientError() || $userData->serverError()) {return redirect()->route("index");};

        $userData = json_decode($userData);
        
        $user = User::updateOrCreate(
            [
                'id' => $userData->id,
            ],
            [
                'username' => $userData->username,
                'email' => $userData->email,
                'avatar' => $userData->avatar,
                'verified' => $userData->verified,
                'refresh_token' => $accessTokenData->refresh_token
            ]
        );
        Auth::login($user);

        return redirect()->route("index");
    }
 
    // Logout function
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();

        return redirect()->route("index");
    }
}