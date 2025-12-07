<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AiController extends Controller
{
    /**
     * Display the AI chat page.
     */
    public function index(): View
    {
        return view('pages.ai-chat');
    }

    /**
     * Display the simple AI page.
     */
    public function simple(): View
    {
        return view('pages.ai-simple');
    }
}
