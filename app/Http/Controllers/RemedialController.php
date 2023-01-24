<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remedial;
use App\Models\RemedialPhoto;
use App\Models\Test;
use App\Models\Board;
use App\Models\Location;
use App\Models\Hospital;

class RemedialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request) {
        $this->validate($request, [
            'circuitNo' => ['required'],
            'room' => ['required'],
            'description' => ['required']
        ]);

        $testID = $request['test_id'];
        $test = Test::find($testID);
        $board = Board::find($test['board_id']);
        $location = Location::find($board['location_id']);
        $hospital = Hospital::find($location['hospital_id']);

        $remedial = Remedial::create(['test_id' => $request['test_id'],
                          'circuitNo' => $request['circuitNo'],
                          'room' => $request['room'],
                          'description' => $request['description'],
                          'approved' => '0']);                  

        foreach($request->file('images') as $image) {
            $name = date('Y-m-d').'-'.$image->getClientOriginalName();
            $target_path = public_path('/remedialPhotos');
            $image->move($target_path, $name);

            RemedialPhoto::create(['remedial_id' => $remedial['id'],
                                   'file' => $name]);
        }

        if($location['type'] === 'main') {
            return redirect()->route('viewHospitalMain', $hospital['id']);
        } elseif($location['type'] === 'community') {
            return redirect()->route('viewHospitalCommunity', $hospital['id']);
        } 
    }

    public function show($id) {
        $remedial = Remedial::findOrFail($id);
        $remedialImages = RemedialPhoto::where('remedial_id', $id)->get();

        return view('hospitals/remedial', ['remedial' => $remedial,
                                           'remedialImages' => $remedialImages]);
    }
}
