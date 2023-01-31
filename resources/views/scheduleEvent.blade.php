@extends('layouts.app')

@section('title', 'Home')

@section('content')
<script> 
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem : "standard",
            initialView: 'dayGridMonth',
            events: @json($events),
            eventDisplay: 'block',
            height: 'auto',
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

<article class="splitSection">
    <section style="width:60%;">
        <div id="calendar"></div>
    </section>

    <section class="eventDetails" style="width:30%;">
        <h2>{{$event->location->name}}</h2>
        <a href="/Schedule"><i class="fa-regular fa-circle-xmark"></i></a>
        <p><b>Hospital:</b> {{$event->location->hospital->name}}</p>
        <p><b>Start:</b> {{date('j F Y, g:i a', strtotime($event->start))}}</p>
        <p><b>End:</b> {{date('j F Y, g:i a', strtotime($event->end))}}</p>
        @if($event->approved === 0)
        <p><b>Approval:</b> Not Approved</p>
        <button>Approve Now</button>
        @elseif($event->approved === 1)
        <p><b>Approval:</b> Approved</p>
        @endif

        @if($event->completed === 0)
        <p><b>Completion Status:</b> Not Completed</p>
        <button>Mark as Completed</button>
        @elseif($event->completed === 1)
        <p><b>Completion Status:</b> Completed</p>
        @endif
    </section>
</article>



<div class="hiddenForm" id="newScheduleForm" style="display:none;">
    <h2>Add New Event</h2>
    <i onClick="closeForm('newScheduleForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeSchedule') }}" method="post">
        @include('includes.error')

        <input type="submit" value="Save">
    </form>
</div>

@endsection