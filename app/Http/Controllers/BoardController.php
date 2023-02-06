<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Board;
use App\Models\Download;
use App\Models\Test;

class BoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
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

    public function show($id) {
        $board = Board::findOrFail($id);
        $tests = Test::where('board_id', $id)->get();
        $downloads = Download::all();
        
        
        return view('hospitals/board', ['board' => $board,
                                        'downloads' => $downloads]);
    }
}
