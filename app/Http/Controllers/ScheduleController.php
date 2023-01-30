<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Location;

class ScheduleController extends Controller
{
    public function index() {
        $events = [];

        $appointments = Schedule::all();

        foreach($appointments as $appointment) {
            $location = Location::find($appointment['location_id']);
            $events[] = [
                'title' => $location['name'],
                'start' => $appointment['start'],
                'end' => $appointment['end'],
            ];
        }

        return view('schedule', compact('events'));
    }
}
