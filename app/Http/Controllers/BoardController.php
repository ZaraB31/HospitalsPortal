<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Board;

class BoardController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'name' => ['required']
        ]);

        $location = Location::find($request['location_id']);
        $hospitalID = $location['hospital_id'];
        $type = $location['type'];

        $input = $request->all();
        Board::create($input);

        if($type === 'main') {
            return redirect()->route('viewHospitalMain', $hospitalID)->with('success', 'Board Created!');
        }
        if($type === 'community') {
            return redirect()->route('viewHospitalCommunity', $hospitalID)->with('success', 'Board Created!');
        }
    }
}
