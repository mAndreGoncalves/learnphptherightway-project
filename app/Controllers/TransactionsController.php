<?php

namespace App\Controllers;

use App\Models\Transaction;
use App\View;

class TransactionsController
{
    public function index(): View
    {
        $transaction = new Transaction();
        return View::make('transactions',['transactions'=>$transaction->get_transactions(), 'revenue'=>$transaction->get_revenue(), 'costs'=>$transaction->get_costs(), 'profit'=>$transaction->get_profit()]);
    }

}