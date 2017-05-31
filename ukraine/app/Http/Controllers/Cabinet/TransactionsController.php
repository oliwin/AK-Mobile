<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use App\Transaction;

use View;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $status = Input::get('status');
        $transactions = Transaction::with("clients")->where(function ($query) use ($request) {

            if (($request->get("status"))) {
                $query->where('status', $request->status);
            }

        })->get();

        $transactions = $transactions->groupBy('transaction_id');

        return View::make('cabinet.distributor.transaction.index', ["transactions" => $transactions, "status" => $status]);
    }

    public function show($id)
    {

        $status = Input::get('status');
        $transaction = Transaction::with("clients", "results", "clientDetails")->where("transaction_id", $id)->get();

        return View::make('cabinet.distributor.transaction.full', ['transaction' => $transaction, "status" => $status]);
    }

}
