<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Board;
use App\Models\Download;
use App\Models\Test;
use App\Models\OldTest;
use Auth;
use File;
use Carbon\Carbon;

use Validator;

class BoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required']
        ])->validateWithBag('newBoard');

        $locationID = $request['location_id'];

        $input = $request->all();
        Board::create($input);
   
        return redirect()->route('viewLocation', $locationID)->with('success', 'Board Created!');

    }

    public function show($id) {
        $board = Board::findOrFail($id);
        $test = Test::where('board_id', $id)->first();
        $oldTests = OldTest::where('board_id', $id)->get();
        $user = Auth()->user();
        $downloads = [];

        if($test === '') {
            $downloads === '';
        } else {
            $downloads = Download::where('test_id', $test['id'])->get(); 
        }
        
        if($downloads === '') {
            return view('hospitals/board', ['board' => $board,
                                        'oldTests' => $oldTests,
                                        'user' => $user]);
        } else {
            return view('hospitals/board', ['board' => $board,
                                        'downloads' => $downloads,
                                        'oldTests' => $oldTests,
                                        'user' => $user]);
        }
    }

    public function circuitLayout(Request $request) {
        Validator::make($request->all(), [
            'file' => ['required', 'image']
        ])->validateWithBag('circuitDiagram');

        $board = Board::findOrFail($request['board_id']);

        $diagram = $request->file('file');
        $diagramName = date('Y-m-d').'-'.$request['name'].'.'.$diagram->getClientOriginalExtension();
        $target_path = public_path('/circuitDiagrams');
        $diagram->move($target_path, $diagramName);

        $board->file = $diagramName;
        $board->circuitLayout = Carbon::now();
        $board->update();

        return redirect()->route('showBoard', $board['id'])->with('success', 'Circuit Layout Evidence Uploaded!');
    }

    public function edit(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required']
        ])->validateWithBag('editBoard');

        $board = Board::findOrFail($request['board_id']);

        $board->name = $request['name'];
        $board->update();

        return redirect()->route('showBoard', $board['id'])->with('success', 'Board Updated!');
    }

    public function delete($id) {
        $board = Board::findOrFail($id);
        $location = Location::find($board['location_id']);
        $tests = Test::where('board_id', $id)->get();
        $oldTests = OldTest::where('board_id', $id)->get();

        if($tests != '') {
            foreach($tests as $test) {
                $deletedFile = File::delete(public_path().'/tests/'.$test['file']);
            }
        }

        if($oldTests != '') {
            foreach($oldTests as $oldTest) {
                $deletedFile = File::delete(public_path().'/OldTests/'.$oldTest['file']);
            }
        }

        $deletedFile = File::delete(public_path().'/circuitDiagrams/'.$board['file']);

        $board->delete(); 

        return redirect()->route('viewLocation', $location['id'])->with('delete', 'Board Deleted!');
    }
}
