<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Hospital;

class HospitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth()->user();
        $hospitals = Hospital::all();
        return view('home', ['user' => $user, 'hospitals' => $hospitals]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => ['required', 'unique:hospitals'],
        ]);

        $input = $request->all();
        Hospital::create($input);

        return redirect('/Hospitals')->with('success', 'Hospital Created!');
    }
}
