@extends('layouts.app')

@section('title', 'Schedule')

@section('content')
<script> 
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem : "standard",
            initialView: 'dayGridMonth',
            hiddenDays: [0, 6],
            displayEventTime: false,
            events: @json($events),
            eventDisplay: 'block',
            height: 'auto',
            initialDate: @json($eventDate),
            eventClick: function(event) {
                if (event.url) {
                    window.open(event.url, "_blank");
                    return false;
                }
            }  
        });
        calendar.render();
    });
</script>

<script>
     document.addEventListener('DOMContentLoaded', function () {
        var x = document.getElementById("contentTextarea");
        x.style.height = x.scrollHeight + "px";
    });  
</script>

<section>
    <h1>Schedule</h1>
</section>

@if($user->type_id === 1)
    <button class="createButton" onClick="openForm('newScheduleForm', '0')"><i class="fa-solid fa-plus"></i></button>
@endif
<section class="eventShow">
    <section class="eventDetails">
        <h2 style="max-width:90%;">{{$event->location->name}}</h2>
        <a href="/Schedule"><i class="fa-regular fa-circle-xmark"></i></a>
        <p><b>Hospital:</b> {{$event->location->hospital->name}}</p>
        <p><b>Start:</b> {{date('j F Y', strtotime($event->start))}}</p>
        <p><b>End:</b> {{date('j F Y', strtotime($event->end))}}</p>
        <p><b>Working Hours:</b> {{$event->hours}}</p>
        @if($event->approved === 0)
        <p><b>Approval:</b> Not Approved</p>
            @if($user->type_id === 3)
            <button onClick="openForm('approveScheduleForm', {{$event->id}})">Approve Now</button>
            @endif
        @elseif($event->approved === 1)
        <p><b>Approval:</b> Approved</p>
            @if($event->completed === 0)
            <p><b>Completion Status:</b> Not Completed</p>
                @if($user->type_id === 1 OR $user->type_id === 2)
                <button onClick="openForm('completeScheduleForm', {{$event->id}})">Mark as Completed</button>
                @endif
            @elseif($event->completed === 1)
            <p><b>Completion Status:</b> Completed</p>
            @endif
        @endif
    </section>

    <section class="eventNotes">
        <h2>Notes</h2>
        @if($event->notes === "")
        <textarea readonly>No notes added.</textarea>
        <button onClick="openForm('addScheduleNoteForm', {{$event->id}})">Add Notes</button>
        @else
        <textarea id="contentTextarea" readonly>{{$event->notes}}</textarea>
        @endif
    </section>
</section>
    
    
<section class="calendar">
    <div id="calendar"></div>
</section>

<div class="hiddenForm" id="newScheduleForm" style="display:none;">
    <h2>Add New Event</h2>
    <i onClick="closeForm('newScheduleForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeSchedule') }}" method="post">
        @include('includes.error')

        <label for="location_id">Location:</label>
        <select name="location_id" id="location_id">
            <option value="">Select...</option>
            @foreach($hospitals as $hospital)
            <optgroup label="{{$hospital->name}}">
            @foreach($locations as $location)
            @if($location->hospital_id === $hospital->id)
            <option value="{{$location->id}}">{{$location->name}}</option>
            @endif
            @endforeach
            </optgroup>
            @endforeach
        </select>

        <label for="start">Start Date and Time:</label>
        <input type="date" name="start" id="start">

        <label for="end">End Date and Time:</label>
        <input type="date" name="end" id="end">

        <label for="hours">Working Hours:</label>
        <select name="hours" id="hours">
            <option value="">Select...</option>
            <option value="Days">Day Work</option>
            <option value="Nights">Night Work</option>
        </select>

        <label for="notes">Notes:</label>
        <textarea name="notes" id="notes"></textarea>

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="approveScheduleForm" style="display:none;">
    <h2>Approve Event</h2>
    <i onClick="closeForm('approveScheduleForm')" class="fa-regular fa-circle-xmark"></i>
    <p>Once this event has been approved, it will be added to the schedule of works and therefore can not be changed.</p>
    <p style="margin-top:0;">Are you sure you want to approve?</p>

    <form action="{{ route('approveSchedule') }}" method="post">
        @include('includes.error')

        <input type="text" name="schedule_id" id="schedule_id" class="foreign_id" style="display:none;">

        <input style="width:70%; margin-left:15%;" type="submit" value="Approve">
    </form>
</div>

<div class="hiddenForm" id="completeScheduleForm" style="display:none;">
    <h2>Mark location as completed</h2>
    <i onClick="closeForm('completeScheduleForm')" class="fa-regular fa-circle-xmark"></i>
    <p>Once this location has been marked as completed, it will be pressumed that all work has been completed. 
        If the work has not been completed, please speak to the site manager.</p>
    <p style="margin-top:0;">Are you sure you want to mark this location as completed?</p>

    <form action="{{ route('completeSchedule') }}" method="post">
        @include('includes.error')

        <input type="text" name="schedule_id" id="schedule_id" class="foreign_id" style="display:none;">

        <input style="width:70%; margin-left:15%;" type="submit" value="Mark as Completed">
    </form>
</div>

<div class="hiddenForm" id="addScheduleNoteForm" style="display:none;">
    <h2>Add Notes</h2>
    <i onClick="closeForm('addScheduleNoteForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('addScheduleNote') }}" method="post">
        @include('includes.error')

        <input type="text" name="schedule_id" id="schedule_id" class="foreign_id" style="display:none;">

        <label for="notes">Note:</label>
        <textarea name="notes" id="notes"></textarea>

        <input style="width:70%; margin-left:15%;" type="submit" value="Add Note">
    </form>
</div>

@endsection