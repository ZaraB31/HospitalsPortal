<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;

use Validator;

class PriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request) {
        Validator::make($request->all(), [
            'defect' => ['required'],
            'price' => ['required', 'decimal:2']
        ])->validateWithBag('newDefect');

        $input = $request->all();
        Price::Create($input);

        return redirect()->route('showAdmin');
    }

    public function edit(Request $request) {
        Validator::make($request->all(), [
            'defect' => ['required'],
            'price' => ['required', 'decimal:2']
        ])->validateWithBag('editDefect');

        $price = Price::findOrFail($request['price_id']);
        $price->defect = $request['defect'];
        $price->price = $request['price'];
        $price->save();

        return redirect()->route('showAdmin')->with('success', 'Remedial Updated!');
    }
}
