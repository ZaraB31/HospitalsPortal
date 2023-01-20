<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Location;
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
        $hospitals = Hospital::all()->sortBy('name');
        $locations = Location::all()->sortBy('name');
        $tests = Test::all();
        $invoices = Invoice::all();

        return view('invoices', ['user' => $user,
                                 'hospitals' => $hospitals,
                                 'locations' => $locations,
                                 'tests' => $tests,
                                 'invoices' => $invoices]);
    }
}
