<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Paddle\Transaction;

class TransactionController extends Controller
{
    /**
     * Display user transactions
     */
    public function index(): View
    {
        return view('pages.transactions.index');
    }

    /**
     * Download transaction invoice PDF
     */
    public function downloadInvoice(Request $request, Transaction $transaction): RedirectResponse
    {
        $user = $request->user();

        if ($user->id !== $transaction->billable_id && ! $user->hasRole('admin')) {
            return redirect()->back()->with('notification', [
                'variant' => 'danger',
                'title' => __('Unauthorized'),
                'message' => __('You are not authorized to download this invoice.'),
            ]);
        }

        return $transaction->redirectToInvoicePdf();
    }
}
