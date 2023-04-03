<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Board;
use App\Models\Drawing;
use App\Models\Hospital;
use App\Models\Company;
use App\Models\Schedule;

use Validator;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required', 'unique:hospitals'],
            'type' => ['required']
        ])->validateWithBag('newLocation');

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

    public function view($id) {
        $user = Auth()->user();
        $location = Location::findOrFail($id);
        $boards = Board::where('location_id', $id)->get();
        $drawings = Drawing::where('location_id', $id)->get();
        $events = Schedule::where('location_id', $id)->get();

        return view('hospitals/location', ['location' => $location,
                                           'boards' => $boards,
                                           'user' => $user,
                                           'drawings' => $drawings,
                                           'events' => $events]);
    }

    public function edit(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required', 'unique:hospitals'],
            'type' => ['required']
        ])->validateWithBag('editLocation');

        $location = Location::findOrFail($request['location_id']);

        $location->name = $request['name'];
        $location->type = $request['type'];
        $location->update();

        return redirect()->route('viewLocation', $location['id'])->with('success', 'Location Updated!');
    }

    public function delete($id) {
        $location = Location::findOrFail($id);
        $drawings = Drawing::where('location_id', $id);
        $boards = Board::where('location_id', $id);

        if($drawings != '') {
            foreach($drawings as $drawing) {
                $deletedDrawing = File::delete(public_path().'/drawings/'.$drawing['file']);
            }
        }

        if($boards != '') {
            foreach($boards as $board) {
                $tests = Test::where('board_id', $board['id'])->get();
                $oldTests = OldTest::where('board_id', $board['id'])->get();

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
            }
        }

        $type = $location['type'];
        $hospital = Hospital::find($location['hospital_id']);

        $location->delete();

        if($type === 'main') {
            return redirect()->route('viewHospitalMain', $hospital['id'])->with('delete', 'Location Deleted!');
        } else if ($type === 'community') {
            return redirect()->route('viewHospitalCommunity', $hospital['id'])->with('delete', 'Location Deleted!');
        }
    }

    public function searchPage() {
        return view('search');
    }

    public function search(Request $request) {
        $user = Auth()->user();
        $locationsArray = [];

        if($request->keyword != '') {
            $locations = location::where('name', 'LIKE', '%'.$request->keyword.'%')->get();

            foreach($locations as $location) {
                array_push($locationsArray, ['locationID' => $location['id'], 'name' => $location['name'], 'hospital_id' => $location['hospital_id'], 'hospital' => $location->hospital['name']]);
            }

            if($user->type_id === 3) {
                $userCompany = Company::where('id', $user->company_id)->first();
                $userHospital = Hospital::where('name', $userCompany->company)->first();
                for($i = 0; $i < count($locationsArray); $i++) {
                    if($locationsArray[$i]['hospital_id'] != $userHospital->id) {
                    array_splice($locationsArray, $i, 1);
                    }
                }
            } 
        } 

        return response()->json([
            'locations' => $locationsArray
        ]);
    }
}
