<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Hospital;
use App\Models\Location;
use App\Models\Board;
use App\Models\Company;
use App\Models\Drawing;

use Validator;

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
        Validator::make($request->all(), [
            'name' => ['required', 'unique:hospitals'],
            'email' => ['required'],
        ])->validateWithBag('newHospital');

        $input = $request->all();
        Hospital::create($input);

        Company::create(['company' => $request['name']]);

        return redirect('/Hospitals')->with('success', 'Hospital Created!');
    }

    public function main($id) {
        $hospital = Hospital::findOrFail($id);
        $user = Auth()->user();
        $locations = Location::where('hospital_id', $id)->where('type', 'main')->get();
        $boards = Board::all();
        $drawings = Drawing::all();
        
        if($user->type_id === 3) {
            $userCompany = Company::find($user['company_id']);
            $userHospital = Hospital::where('name', $userCompany->company)->first();

            if($userHospital->id !== $hospital->id) {
                return redirect()->route('displayHospitals')->with('failure', "Sorry, you do not have access to this hospital's data");
            }
        }

        if($locations->isNotEmpty()){
            foreach($locations as $location){
                $boards = Board::where('location_id', $location['id'])->get();
                $amount = count($boards);
                $id = $location['id'];
                $locationBoards[$id] = $amount;
            }
        }

        if($locations->isNotEmpty()) {
            foreach($locations as $location){
                $drawings = Drawing::where('location_id', $location['id'])->get();
                $amount = count($drawings);
                $id = $location['id'];
                $locationDrawings[$id] = $amount;
            }
        }

        return view('hospitals/main', ['hospital' => $hospital, 
                                       'user' => $user,
                                       'locations' => $locations,
                                       'locationBoards' => $locationBoards,
                                       'locationDrawings' => $locationDrawings]);
    }

    public function community($id) {
        $hospital = Hospital::findOrFail($id);
        $user = Auth()->user();
        $locations = Location::all()->where('hospital_id', $id)->where('type', 'community');
        $boards = Board::all();
        $drawings = Drawing::all();

        if($user->type_id === 3) {
            $userCompany = Company::find($user['company_id']);
            $userHospital = Hospital::where('name', $userCompany->company)->first();

            if($userHospital->id !== $hospital->id) {
                return redirect()->route('displayHospitals')->with('failure', "Sorry, you do not have access to this hospital's data");
            }
        }
        
        if($locations->isNotEmpty()){
            foreach($locations as $location){
                $boards = Board::where('location_id', $location['id'])->get();
                $amount = count($boards);
                $id = $location['id'];
                $locationBoards[$id] = $amount;
            }
        }

        if($locations->isNotEmpty()) {
            foreach($locations as $location){
                $drawings = Drawing::where('location_id', $location['id'])->get();
                $amount = count($drawings);
                $id = $location['id'];
                $locationDrawings[$id] = $amount;
            }
        }

        return view('hospitals/community', ['hospital' => $hospital, 
                                       'user' => $user,
                                       'locations' => $locations,
                                       'locationBoards' => $locationBoards,
                                       'locationDrawings' => $locationDrawings]);
    }

    public function mainSearch(Request $request) {
        $output="";
        $data = $request->get('query');
        if($query = "") {
            $output .= '<li>No Results Found</li>';
        } else {
            $locations = Location::where('name','LIKE','%'.$data.'%')->get();
            if($locations != "") {
                foreach ($locations as $location) {
                    $output.='<li>'.$location->name.'</li>';
                }
            } else {
                $output .= '<li>No Results Found</li>';
            }            
        }
        echo json_encode($output);
    }
}
