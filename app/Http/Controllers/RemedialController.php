<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remedial;
use App\Models\RemedialPhoto;
use App\Models\RemedialPrice;
use App\Models\Test;
use App\Models\Board;
use App\Models\Location;
use App\Models\Hospital;
use App\Models\Price;
use Auth;

class RemedialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth()->user();
        $remedials = Remedial::all()->sortBy('created_at');

        return view('remedials/index', ['user' => $user,
                                        'remedials' => $remedials]);
    }

    public function create() {
        $hospitals = Hospital::all();
        $locations = Location::all();
        $boards = Board::all();
        $prices = Price::all();

        return view('remedials/create', ['hospitals' => $hospitals,
                                         'locations' => $locations,
                                         'boards' => $boards,
                                         'prices' => $prices]);
    }
    
    public function store(Request $request) {
        $this->validate($request, [
            'circuitNo' => ['required'],
            'room' => ['required'],
            'description' => ['required'],
            'estimatedCompletion' => ['required', 'date']
        ]);

        $remedial = Remedial::create(['board_id' => $request['board_id'],
                                      'circuitNo' => $request['circuitNo'],
                                      'room' => $request['room'],
                                      'description' => $request['description'],
                                      'estimatedCompletion' => $request['estimatedCompletion'],
                                      'approved' => '0']); 

        foreach ($request->get('defect') as $defect) {
            $prices = RemedialPrice::create(['remedial_id' => $remedial['id'],
                                             'price_id' => $defect]);    
        }
                     
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
        $remedialPrices = RemedialPrice::where('remedial_id', $id)->get();

        return view('remedials/show', ['remedial' => $remedial,
                                       'remedialImages' => $remedialImages,
                                       'remedialPrices' => $remedialPrices]);
    }
}
