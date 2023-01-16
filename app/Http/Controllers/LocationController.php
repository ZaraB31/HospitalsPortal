<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'name' => ['required', 'unique:hospitals'],
            'type' => ['required']
        ]);

        $hospitalID = $request['hospital_id'];
        $type = $request['type'];

        $input = $request->all();
        Location::create($input);

        if($type === 'main') {
            return redirect()->route('viewHospitalMain', $hospitalID)->with('success', 'Location Created!');
        }
        if($type === 'community') {
            return redirect()->route('viewHospitalCommunity', $hospitalID)->with('success', 'Location Created!');
        }
    }
}
