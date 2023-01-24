<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;

class PriceController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'defect' => ['required'],
            'price' => ['required', 'decimal:2']
        ]);

        $input = $request->all();
        Price::Create($input);

        return redirect()->route('showAdmin');
    }
}
