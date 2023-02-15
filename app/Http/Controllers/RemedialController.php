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
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewRemedial;
use App\Mail\ApprovedRemedial;

class RemedialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth()->user();
        $remedials = Remedial::all()->sortByDesc('created_at');

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

        $userID = Auth()->user()->id;

        $board = Board::find($request['board_id']);
        $location = Location::find($board['location_id']);
        $hospital = Hospital::find($location['hospital_id']);

        $remedial = Remedial::create(['board_id' => $request['board_id'],
                                      'user_id' => $userID,
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

        Mail::to($hospital['email'])->send(new NewRemedial($remedial));

        return redirect()->route('displayRemedial');
    }

    public function show($id) {
        $remedial = Remedial::findOrFail($id);
        $remedialImages = RemedialPhoto::where('remedial_id', $id)->get();
        $remedialPrices = RemedialPrice::where('remedial_id', $id)->get();
        $prices = Price::all();
        $total = 0;
        $user =Auth()->user();

        foreach($prices as $price) {
            foreach($remedialPrices as $remedialPrice) {
                if($price->id === $remedialPrice->price_id) {
                    $total += $price->price;
                }
            }
        }
        $total = ($total / 100) * 120;

        return view('remedials/show', ['remedial' => $remedial,
                                       'remedialImages' => $remedialImages,
                                       'remedialPrices' => $remedialPrices,
                                       'total' => $total,
                                       'user' => $user]);
    }

    public function approve(Request $request) {
        $id = $request['remedial_id'];
        $remedial = Remedial::findOrFail($id);
        $remedial->approved = "1";
        $remedial->update();

        $user = User::find($remedial['user_id']);
        Mail::to($user['email'])->send(new ApprovedRemedial($remedial));

        return redirect()->route('showRemedial', $id);
    }
}
