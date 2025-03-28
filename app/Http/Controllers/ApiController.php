<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function docs()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (!$user->api_key) {
                $api_key = Str::random(64);
                User::where('id', Auth::id())->update(['api_key' => $api_key]);
                // Odświeżamy model użytkownika
                $user = User::find(Auth::id());
            }
            return view('Api', [
                'debug' => [
                    'user_id' => $user->id,
                    'api_key' => $user->api_key,
                    'all_users' => User::all()->map(function($u) {
                        return [
                            'id' => $u->id,
                            'api_key' => $u->api_key
                        ];
                    })
                ]
            ]);
        }
        return view('Api');
    }

    public function getLinks(Request $request)
    {
        $key = $request->query('key');
        $user = User::where('api_key', $key)->first();
        
        if (!$user) {
            return response()->json([
                'error' => 'Invalid API key',
                'debug' => [
                    'received_key' => $key,
                    'users' => User::all()->map(function($user) {
                        return [
                            'id' => $user->id,
                            'api_key' => $user->api_key
                        ];
                    })
                ]
            ], 401);
        }
        
        $links = $user->links;
        return response()->json($links);
    }

    public function createLink(Request $request)
    {
        $key = $request->input('key');
        $user = User::where('api_key', $key)->first();
        
        if (!$user) {
            return response()->json([
                'error' => 'Invalid API key',
                'debug' => [
                    'received_key' => $key,
                    'users' => User::all()->map(function($user) {
                        return [
                            'id' => $user->id,
                            'api_key' => $user->api_key
                        ];
                    })
                ]
            ], 401);
        }

        if (!filter_var($request->orginal_link, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid URL'], 400);
        }

        do {
            $shortLink = Str::random(6);
        } while (ShortLink::where('short_link', $shortLink)->exists());

        $link = new ShortLink();
        $link->orginal_link = $request->orginal_link;
        $link->short_link = $shortLink;
        $link->user_id = $user->id;
        $link->save();

        return response()->json($link, 201);
    }
}
