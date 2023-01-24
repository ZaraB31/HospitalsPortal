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

    public function index() {
        return view('remedials/index');
    }

    public function create() {
        return view('remedials/create');
    }
    
    public function store(Request $request) {
        $this->validate($request, [
            'circuitNo' => ['required'],
            'room' => ['required'],
            'description' => ['required'],
            'expectedCompleteion' => ['required', 'date']
        ]);

        $remedial = Remedial::create(['board_id' => $request['board_id'],
                          'circuitNo' => $request['circuitNo'],
                          'room' => $request['room'],
                          'description' => $request['description'],
                          'expectedCompletion' => $request['expectedCompletion'],
                          'approved' => '0']);                  

        foreach($request->file('images') as $image) {
            $name = date('Y-m-d').'-'.$image->getClientOriginalName();
            $target_path = public_path('/remedialPhotos');
            $image->move($target_path, $name);

            RemedialPhoto::create(['remedial_id' => $remedial['id'],
                                   'file' => $name]);
        }

        return redirect()->route('displayRemedial');
    }

    public function show($id) {
        $remedial = Remedial::findOrFail($id);
        $remedialImages = RemedialPhoto::where('remedial_id', $id)->get();

        return view('remedials/show', ['remedial' => $remedial,
                                           'remedialImages' => $remedialImages]);
    }
}
