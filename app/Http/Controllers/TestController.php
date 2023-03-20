<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Board;
use App\Models\Location;
use App\Models\Hospital;
use App\Models\Company;
use Auth;
use Validator;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewTest;
use App\Mail\AccountsNewTest;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth()->user();
        $allTests = Test::all();
        $tests = [];
        $hospitals = Hospital::all();

        if($user->type_id === 1 OR $user->type_id === 4 OR $user->type_id === 2) {
            $tests = Test::all()->sortByDesc('created_at');
        } else if ($user->type_id === 3) {
            $userCompany = Company::find($user['company_id']);
            $userHospital = Hospital::where('name', $userCompany->company)->first();
            foreach($allTests as $allTest) {
                $board = Board::find($allTest['board_id']);
                $location = Location::find($board['location_id']);
                $hospital = Hospital::find($location['hospital_id']);
                if($hospital->id === $userHospital->id) {
                    array_push($tests, $allTest);
                }
            }
        }

        return view('hospitals/testsIndex', ['tests' => $tests,
                                             'hospitals' => $hospitals,
                                             'user' => $user]);
    }

    public function hospitals($id) {
        $user = Auth()->user();
        $allTests = Test::all();
        $hospitals = Hospital::all();
        $hospital = Hospital::findOrFail($id);
        $tests = [];

        foreach ($allTests as $allTest) {
            $board = Board::find($allTest['board_id']);
            $location = Location::find($board['location_id']);
            $hospitalID = Hospital::find($location['hospital_id']);
            if($hospital->id === $hospitalID->id) {
                array_push($tests, $allTest);
            }
        }

        return view('hospitals/testsHospitals', ['tests' => $tests,
                                                 'hospital' => $hospital,
                                                 'hospitals' => $hospitals,
                                                 'user' => $user]);
    }
    
    public function store(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required'],
            'file' => ['required','file', 'mimes:pdf'],
            'circuits' => ['required', 'numeric'],
            'result' => ['required']
        ])->validateWithBag('newTest');

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

        Mail::to($hospital['email'])->send(new NewTest($test));
        //Mail::to('accounts@mega-electrical.co.uk')->send(new AccountsNewTest($test));

        return redirect()->route('showBoard', $id)->with('success', 'Test Uploaded!');
    }

    public function delete($id) {
        $test = Test::findOrFail($id);
        $board = Board::find($test['board_id']);

        $deletedFile = File::delete(public_path().'/tests/'.$test['file']);
        $test->delete();

        return redirect()->route('showBoard', $board['id']);
    }
}
