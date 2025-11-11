<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function index()
    {
        return view('test.index');
    }
    public function ai_test(Request $request)
    {
        $text = 'Hello AI';

        // FastAPIのエンドポイントにPOST
        $response = Http::post('http://localhost:8090/predict', [
            'text' => $text
        ]);

        Log::info('response', [$response->json()]);

        return view('test.index');
    }
}
