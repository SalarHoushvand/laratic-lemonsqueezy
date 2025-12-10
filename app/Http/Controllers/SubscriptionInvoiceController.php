<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionInvoice;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SubscriptionInvoiceController extends Controller
{
    /**
     * Display user subscription invoices
     */
    public function index(): View
    {
        return view('pages.subscription-invoices.index');
    }
}

