<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Auth;

use Validator;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth()->user();
        $invoices = Invoice::all()->sortByDesc('created_at');

        return view('invoices', ['user' => $user,
                                 'invoices' => $invoices]);
    }

    public function store(Request $request) {
        Validator::make($request->all(), [
            'invoiceNo' => ['required'],
            'sentDate' => ['required', 'date'],
        ])->validateWithBag('newInvoice');

        Invoice::create(['invoiceNo' => $request['invoiceNo'],
                         'sentDate' => $request['sentDate'],
                         'paid' => "0",
                         'details' => $request['details']]);

        return redirect()->route('showInvoice');
    }

    public function paid(Request $request) {
        $invoice = Invoice::findOrFail($request['invoice_id']);

        $invoice->paid = "1";
        $invoice->update();

        return redirect()->route('showInvoice');
    }
}
