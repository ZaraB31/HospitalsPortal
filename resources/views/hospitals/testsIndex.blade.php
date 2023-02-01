@extends('layouts.app')

@section('title', 'Test Results')

@section('content')
<section>
    <a href="/Hospitals"><i class="fa-solid fa-arrow-left"></i> Back</a>
</section>

<section>
    <h1>Recent Test Results</h1>
</section>

<section>
    <table>
        <tr>
            <th>Location</th>
            <th>Date Uploaded</th>
            <th>Result</th>
        </tr>
        @foreach($tests as $test)
        <tr>
            <td style="word-wrap: break-word; width:55%;"><a href="/Hospitals/Boards/{{$test->board->id}}">
                {{$test->board->location->hospital->name}} - {{$test->board->location->name}} - {{$test->board->name}} <i class="fa-solid fa-arrow-right"></i></a></td>
            <td style="word-wrap: break-word; width:30%;">{{date('j F Y, g:i a', strtotime($test->created_at))}}</td>
            @if($test->result === 'Unsatisfactory')
            <td style="background-color:#C01D1F; word-wrap:break-word; width:15%; color:white;">{{$test->result}}</td>
            @elseif($test->result === 'Satisfactory')
            <td style="background-color: #1FC01D; word-wrap: break-word; width:15%;">{{$test->result}}</td>
            @endif
        </tr>
        @endforeach
    </table>
</section>
@endsection