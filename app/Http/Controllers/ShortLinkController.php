<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreShortLinkRequest;
use App\Http\Requests\UpdateShortLinkRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ShortLinkController extends Controller
{
    // Redirect to main view
    public function index()
    {
        return view("Welcome");
    }
    
    // Redirect to links list view
    public function links(){
        $links = Auth::User()->links;
        return view("Links", ['Links' => $links]);
    }
    
    // Delete link
    public function destroy(int $id){
        $shortLink = ShortLink::find($id);
        if($shortLink==null) {
            return redirect()->route('index');
        }
        ShortLink::destroy($id);
        
        return redirect()->route('link.list');
    }
    
    // Post new link
    public function store(StoreShortLinkRequest $request)
    {
        if(!filter_var($request->orginal_link, FILTER_VALIDATE_URL)){
            return redirect()->route('index');
        }

        do {
            $shortLink = Str::random(6);
        } while (ShortLink::where('short_link', $shortLink)->exists());

        $link = new ShortLink();
        $link->orginal_link = $request->orginal_link;
        $link->short_link = $shortLink;
        $link->user_id = $request->user()->id;
        $link->save();
        
        return view("Welcome", ['ShortLink' => $link]);
    }
    
    // Redirect to link
    public function show(String $link){
        $shortLink = ShortLink::where('short_link', $link)->first();
        if($shortLink == null){
            return view("Welcome");
        }
        $shortLink->clicks = $shortLink->clicks + 1;
        $shortLink->save();
        return redirect($shortLink->orginal_link);
    }
    
    // Download qrcode
    public function qrcode(int $id){
        $shortLink = ShortLink::where('id', $id)->first();
        if($shortLink == null){
            return view("Welcome");
        }
        $dest = storage_path('app/qrCode.svg');
        $url = route('get', $shortLink->short_link);

        QrCode::margin(2)->size(400)->generate($url, $dest);
        return response()->download($dest);
    }
}
