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
        });
        calendar.render();
    });
</script>

<section>
    <h1>Schedule</h1>
</section>

<section>
    <div id="calendar"></div>
</section>

@endsection