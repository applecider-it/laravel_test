<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * ホームコントローラー
 */
class HomeController extends Controller
{
    public function __construct(
    ) {}

    public function index(Request $request)
    {
        return view('home.index');
    }

    public function dashboard(Request $request)
    {
        return view('home.dashboard');
    }
}
