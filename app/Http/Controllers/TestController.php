<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Board;
use App\Models\Location;
use App\Models\Hospital;
use Validator;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewTest;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $tests = Test::all()->sortByDesc('created_at');

        return view('hospitals/testsIndex', ['tests' => $tests]);
    }
    
    public function store(Request $request) {
        $this->validate($request, [
            'name' => ['required'],
            'file' => ['required','file', 'mimes:pdf'],
            'circuits' => ['required', 'numeric'],
            'result' => ['required']
        ]);

        $test = $request->file('file');
        $testName = date('Y-m-d').'-'.$request['name'].'.'.$test->getClientOriginalExtension();
        $target_path = public_path('/tests');
        $test->move($target_path, $testName);

        $id = $request['board_id'];
        $board = Board::find($id);
        $location = Location::find($board->location_id);
        $hospital = Hospital::find($location->hospital_id);
        
        $test = Test::create(['name' => $request['name'],
                      'file' => $testName,
                      'board_id' => $request['board_id'],
                      'circuits' => $request['circuits'],
                      'result' => $request['result']]);

        Mail::to('zara.bostock@mega-electrical.co.uk')->send(new NewTest($test));

        if($location->type === 'main') {
            return redirect()->route('viewHospitalMain', $hospital->id)->with('success', 'Test Uploaded!');
        } else if ($location->type === 'community') {
            return redirect()->route('viewHospitalCommunity', $hospital->id)->with('success', 'Test Uploaded!');
        }
    }
}
