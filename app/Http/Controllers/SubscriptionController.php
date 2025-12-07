<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    /**
     * Display subscription pending page
     */
    public function pending(): View
    {
        return view('pages.subscription.pending');
    }

    /**
     * Check if user has active subscription
     */
    public function status(Request $request): JsonResponse
    {
        return response()->json([
            'active' => $request->user()->subscribed(),
        ]);
    }
}
