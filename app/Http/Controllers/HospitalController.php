<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Hospital;
use App\Models\Location;
use App\Models\Board;

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
            'email' => ['required'],
        ]);

        $input = $request->all();
        Hospital::create($input);

        return redirect('/Hospitals')->with('success', 'Hospital Created!');
    }

    public function main($id) {
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

        return view('hospitals/main', ['hospital' => $hospital, 
                                       'user' => $user,
                                       'locations' => $locations,
                                       'locationBoards' => $locationBoards]);
    }

    public function community($id) {
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

        return view('hospitals/community', ['hospital' => $hospital, 
                                       'user' => $user,
                                       'locations' => $locations,
                                       'locationBoards' => $locationBoards]);
    }
}
