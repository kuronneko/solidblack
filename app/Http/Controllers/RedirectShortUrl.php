<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class RedirectShortUrl extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Setting $setting)
    {
        $hostname = $_SERVER["HTTP_HOST"];
        $protocol = 'http://';
        $api = '/api/network/get/';
        $url = $protocol.$hostname.$api.$setting->uuid;
        return redirect()->to($url);
    }
}
