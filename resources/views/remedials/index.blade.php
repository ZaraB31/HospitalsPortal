@extends('layouts.app')

@section('title', 'Remedial Works')

@section('content')
<section>
    <a href="/Hospitals"><i class="fa-solid fa-arrow-left"></i> Back</a>
</section>

<section>
    <h1>Remedial Works</h1>
</section>

@if($user->type_id === 1)
    <button class="createButton"><a href="/Hospitals/Board/Remedials/Create"><i class="fa-solid fa-plus"></i></a></button>
@endif

<section>
    <table>
        <tr>
            <th>Location</th>
            <th>Date Raised</th>
        </tr>
        @foreach($remedials as $remedial)
        <tr>
            <td><a href="/Hospitals/Board/Remedials/{{$remedial->id}}">{{$remedial->board->location->hospital->name}} - {{$remedial->board->location->name}} - {{$remedial->board->name}} <i class="fa-solid fa-arrow-right"></i></a></td>
            <td style="border-left: 1px solid #9098A3;">{{date('j F Y, g:i a', strtotime($remedial->created_at))}}</td>
        </tr>
        @endforeach
    </table>
</section>

@endsection