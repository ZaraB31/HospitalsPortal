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
            nextDayThreshold: "00:00:00",
            displayEventTime: false,
            events: @json($events),
            eventDisplay: 'block',
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

<section>
    <h1>Schedule</h1>
</section>

@if($user->type_id === 1)
    <button class="createButton" onClick="openForm('newScheduleForm', '0')"><i class="fa-solid fa-plus"></i></button>
@endif

<section>
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

@endsection