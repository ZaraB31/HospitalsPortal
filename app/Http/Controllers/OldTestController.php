<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Location;
use App\Models\Board;
use App\Models\OldTest;

use Validator;

class OldTestController extends Controller
{
    public function oldMain($id) {
        $hospital = Hospital::findOrFail($id);
        $user = Auth()->user();
        $locations = Location::all()->where('hospital_id', $id)->where('type', 'main');
        $boards = Board::all();
        $locationBoards = [];
        
        foreach($locations as $location) {
            foreach($boards as $board) {
                if($board['location_id'] === $location['id']) {
                    $locationBoards[] = $board;
                }
            }
        }

        return view('hospitals/oldMain', ['hospital' => $hospital, 
                                       'user' => $user,
                                       'locations' => $locations,
                                       'locationBoards' => $locationBoards]);
    }

    public function oldCommunity($id) {
        $hospital = Hospital::findOrFail($id);
        $user = Auth()->user();
        $locations = Location::all()->where('hospital_id', $id)->where('type', 'community');
        $boards = Board::all();
        $locationBoards = [];
        
        foreach($locations as $location) {
            foreach($boards as $board) {
                if($board['location_id'] === $location['id']) {
                    $locationBoards[] = $board;
                }
            }
        }

        return view('hospitals/oldCommunity', ['hospital' => $hospital, 
                                       'user' => $user,
                                       'locations' => $locations,
                                       'locationBoards' => $locationBoards]);
    }

    public function store(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required'],
            'file' => ['required','file', 'mimes:pdf'],
        ])->validateWithBag('oldTest');

        $test = $request->file('file');
        $testName = date('Y-m-d').'-'.$request['name'].'.'.$test->getClientOriginalExtension();
        $target_path = public_path('/OldTests');
        $test->move($target_path, $testName);

        $id = $request['board_id'];
        
        $test = OldTest::create(['name' => $request['name'],
                              'file' => $testName,
                              'board_id' => $request['board_id']]);

        return redirect()->route('showBoard', $id)->with('success', 'Test Uploaded!');
    }

    public function download($id) {
        $test = OldTest::findOrFail($id);
        $boardID = $test['board_id'];
        
        $file = $test['file'];
        $filePath = public_path('/OldTests/'.$file);

        return Response()->download($filePath);
    }
}
