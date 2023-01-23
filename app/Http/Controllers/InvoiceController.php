<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Invoice;
use Auth;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth()->user();
        $tests = Test::all()->sortByDesc('created_at');

        return view('invoices', ['user' => $user,
                                 'tests' => $tests]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'invoiceNo' => ['required'],
            'sentDate' => ['required', 'date'],
        ]);

        Invoice::create(['test_id' => $request['test_id'],
                         'invoiceNo' => $request['invoiceNo'],
                         'sentDate' => $request['sentDate'],
                         'paid' => "0"]);

        return redirect()->route('showInvoice');
    }
}
