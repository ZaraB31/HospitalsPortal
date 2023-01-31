<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Location;
use App\Models\Hospital;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewEvent;
use App\Mail\ApprovedEvent;

class ScheduleController extends Controller
{
    public function index() {
        $events = [];

        $appointments = Schedule::all();

        foreach($appointments as $appointment) {
            $location = Location::find($appointment['location_id']);
            $today = Carbon::now();
            $id = strval($appointment['id']);
            $url = 'http://localhost:8000/Schedule/'.$id;

            if($appointment['approved'] == 0 && $appointment['completed'] == 0) {
                $colour = '#E48F1B';
            }
            elseif($appointment['approved'] == 1 && $appointment['completed'] == 0) {
                $colour = '#6D1DC0';
            }
            elseif($appointment['approved'] == 1 && $appointment['completed'] == 0 && $appointment['end'] > $today) {
                $colour = '#C01D1F';
            }
            elseif($appointment['approved'] == 1 && $appointment['completed'] == 1) {
                $colour = '#1FC01D';
            }

            $events[] = [
                'title' => $location['name'],
                'start' => $appointment['start'],
                'end' => $appointment['end'],
                'url' => $url,
                'backgroundColor' => $colour,
                'borderColor' => $colour,
            ];
        }

        $user = Auth()->User();
        $locations = Location::all()->sortBy('name');
        $hospitals = Hospital::all()->sortBy('name');

        return view('schedule', ['events' => $events,
                                 'user' => $user,
                                 'locations' => $locations,
                                 'hospitals' => $hospitals]);
    }

    public function show($id) {

        $events = [];

        $appointments = Schedule::all();

        foreach($appointments as $appointment) {
            $location = Location::find($appointment['location_id']);
            $today = Carbon::now();
            $id = strval($appointment['id']);
            $url = 'http://localhost:8000/Schedule/'.$id;

            if($appointment['approved'] == 0 && $appointment['completed'] == 0) {
                $colour = '#E48F1B';
            }
            elseif($appointment['approved'] == 1 && $appointment['completed'] == 0) {
                $colour = '#6D1DC0';
            }
            elseif($appointment['approved'] == 1 && $appointment['completed'] == 0 && $appointment['end'] > $today) {
                $colour = '#C01D1F';
            }
            elseif($appointment['approved'] == 1 && $appointment['completed'] == 1) {
                $colour = '#1FC01D';
            }

            $events[] = [
                'title' => $location['name'],
                'start' => $appointment['start'],
                'end' => $appointment['end'],
                'url' => $url,
                'backgroundColor' => $colour,
                'borderColor' => $colour,
            ];
        }

        $event = Schedule::findOrFail($id);
        $user = Auth()->User();
        $locations = Location::all()->sortBy('name');
        $hospitals = Hospital::all()->sortBy('name');

        return view('scheduleEvent', ['events' => $events,
                                      'event' => $event,
                                      'user' => $user,
                                      'locations' => $locations,
                                      'hospitals' => $hospitals]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'location_id' => ['required'],
            'start' => ['required', 'date', 'after_or_equal:today'],
            'end' => ['required', 'date', 'after:start'],
        ]);

        $location = Location::find($request['location_id']);
        $hospital = Hospital::find($location['hospital_id']);

        $event = Schedule::create(['location_id' => $request['location_id'],
                                   'start' => $request['start'],
                                   'end' => $request['end'],
                                   'approved' => 0,
                                   'completed' => 0]);

        Mail::to($hospital['email'])->send(new NewEvent($event));

        return redirect()->route('showSchedule');
    }

    public function approve(Request $request) {
        $id = $request['schedule_id'];
        $event = Schedule::findOrFail($id);

        $event->approved = "1";
        $event->update();

        Mail::to('zara.bostock@mega-electrical.co.uk')->send(new ApprovedEvent($event));

        return redirect()->route('showEvent', $id);
    }
}
