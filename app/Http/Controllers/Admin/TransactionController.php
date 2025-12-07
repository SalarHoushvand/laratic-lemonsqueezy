<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions
     *
     * Authorization is handled by the 'role:admin' middleware at the route level
     */
    public function index(): View
    {
        return view('pages.admin.transactions.index');
    }
}
