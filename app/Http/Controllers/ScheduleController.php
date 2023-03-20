<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Location;
use App\Models\Hospital;
use App\Models\Company;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewEvent;
use App\Mail\ApprovedEvent;
use App\Mail\CompletedEvent;

use Validator;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        $user = Auth()->user();
        $userCompany = Company::find($user['company_id']);
        $userHospital = Hospital::where('name', $userCompany->company)->first();
        if($user['type_id'] === 3) {
            $userLocations = Location::where('hospital_id', $userHospital['id'])->get();
        } else {
            $userLocations = [];
        }
        
        $events = [];

        $appointments = Schedule::all();

        foreach($appointments as $appointment) {
            $location = Location::find($appointment['location_id']);
            $hospital = Hospital::find($location['hospital_id']);
            $today = Carbon::now();
            $id = strval($appointment['id']);
            $url = 'https://megaelectrical-hospitalstesting.co.uk/Schedule/'.$id;

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

            if($user->type_id === 1 OR $user->type_id === 4 or $user->type_id === 2) {
                $events[] = [
                    'title' => $location['name'],
                    'start' => $appointment['start'],
                    'end' => $appointment['end'],
                    'url' => $url,
                    'backgroundColor' => $colour,
                    'borderColor' => $colour,
                ];
            } else if($user->type_id === 3 and $userHospital->id === $hospital->id){
                $events[] = [
                    'title' => $location['name'],
                    'start' => $appointment['start'],
                    'end' => $appointment['end'],
                    'url' => $url,
                    'backgroundColor' => $colour,
                    'borderColor' => $colour,
                ];
            }
            
        }

        $user = Auth()->User();
        $locations = Location::all()->sortBy('name');
        $hospitals = Hospital::all()->sortBy('name');

        return view('schedule', ['events' => $events,
                                 'user' => $user,
                                 'locations' => $locations,
                                 'hospitals' => $hospitals,
                                 'userLocations' => $userLocations]);
    }

    public function show($id) {
        $user = Auth()->user();
        $userCompany = Company::find($user['company_id']);
        $userHospital = Hospital::where('name', $userCompany->company)->first();

        $events = [];

        $appointments = Schedule::all();

        foreach($appointments as $appointment) {
            $location = Location::find($appointment['location_id']);
            $hospital = Hospital::find($location['hospital_id']);
            $today = Carbon::now();
            $appointmentID = strval($appointment['id']);
            $url = 'https://megaelectrical-hospitalstesting.co.uk/Schedule/'.$appointmentID;

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

            if($user->type_id === 1 OR $user->type_id === 4 or $user->type_id === 2) {
                $events[] = [
                    'title' => $location['name'],
                    'start' => $appointment['start'],
                    'end' => $appointment['end'],
                    'url' => $url,
                    'backgroundColor' => $colour,
                    'borderColor' => $colour,
                ];
            } else if($user->type_id === 3 and $userHospital->id === $hospital->id){
                $events[] = [
                    'title' => $location['name'],
                    'start' => $appointment['start'],
                    'end' => $appointment['end'],
                    'url' => $url,
                    'backgroundColor' => $colour,
                    'borderColor' => $colour,
                ];
            }
        }

        $event = Schedule::findOrFail($id);
        $user = Auth()->User();
        $locations = Location::all()->sortBy('name');
        $hospitals = Hospital::all()->sortBy('name');

        $eventDate = date_create($event['start']);
        $eventDate = date_format($eventDate, 'Y-m-d');
       
        return view('scheduleEvent', ['events' => $events,
                                      'event' => $event,
                                      'user' => $user,
                                      'eventDate' => $eventDate,
                                      'locations' => $locations,
                                      'hospitals' => $hospitals]);
    }

    public function store(Request $request) {
        Validator::make($request->all(), [
            'location_id' => ['required'],
            'start' => ['required', 'date', 'after_or_equal:today'],
            'end' => ['required', 'date', 'after_or_equal:start'],
            'hours' => ['required'],
        ])->validateWithBag('newSchedule');

        $user = Auth()->user();
        $endTime = date_create($request['end']);
        $end = date_modify($endTime, "+5 minutes");

        $location = Location::find($request['location_id']);
        $hospital = Hospital::find($location['hospital_id']);

        $event = Schedule::create(['location_id' => $request['location_id'],
                                   'start' => $request['start'],
                                   'end' => $end,
                                   'hours' => $request['hours'],
                                   'notes' => $request['notes'],
                                   'approved' => 0,
                                   'completed' => 0]);

        if($user['type_id'] === 1) {
            Mail::to($hospital['email'])->send(new NewEvent($event));
        } elseif($user['type_id'] === 3) {
            Mail::to('lance.roberts@mega-electrical.co.uk')->send(new NewEvent($event));
            Mail::to('david.hughes@mega-electrical.co.uk')->send(new NewEvent($event));
        }

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

    public function complete(Request $request) {
        $id = $request['schedule_id'];
        $event = Schedule::findOrFail($id);

        $location = Location::find($event['location_id']);
        $hospital = Hospital::find($location['hospital_id']);

        $event->completed = "1";
        $event->update();

        Mail::to($hospital['email'])->send(new CompletedEvent($event));

        return redirect()->route('showEvent', $id);
    }

    public function edit(Request $request) {
        Validator::make($request->all(), [
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after_or_equal:start'],
            'hours' => ['required'],
        ])->validateWithBag('editSchedule');

        $endTime = date_create($request['end']);
        $end = date_modify($endTime, "+5 minutes");

        $event = Schedule::findOrFail($request['schedule_id']);
        $event->start = $request['start'];
        $event->end = $end;
        $event->hours = $request['hours'];
        $event->update();

        return redirect()->route('showEvent', $request['schedule_id'])->with('success', 'Event Updated!');
    }

    public function delete($id) {
        $event = Schedule::findOrFail($id);
        $event->delete();

        return redirect()->route('showSchedule')->with('delete', 'Event deleted');
    }

    public function notes(Request $request) {
        Validator::make($request->all(), [
            'notes' => ['required'],
        ])->validateWithBag('newScheduleNote');

        $schedule = Schedule::findOrFail($request['schedule_id']);
        $schedule->notes = $request['notes'];
        $schedule->update();

        return redirect()->route('showEvent', $request['schedule_id']);
    }

    public function editNote(Request $request) {
        Validator::make($request->all(), [
            'notes' => ['required'],
        ])->validateWithBag('editScheduleNote');

        $event = Schedule::findOrFail($request['schedule_id']);
        $event->notes = $request['notes'];
        $event->update();

        return redirect()->route('showEvent', $event['id'])->with('success', 'Event notes updated!');
    }

    public function deleteNote($id) {
        $event = Schedule::findOrFail($id);
        $event->notes = "";
        $event->update();

        return redirect()->route('showEvent', $event['id'])->with('delete', 'Event note deleted');
    }
}
