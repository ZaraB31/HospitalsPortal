@extends('layouts.app')

@section('title', 'Main')

@section('content')

<section>
    <a href="/Hospitals"><i class="fa-solid fa-arrow-left"></i> Back</a>
</section>

@if (\Session::has('success'))
    <div class="messageSent">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif

<section>
    <h1>{{$hospital->name}} - Main</h1>
</section>

<section class="secondNav">
    <ul>
        <li><a href="/Hospitals/{{$hospital->id}}/Main">Current Test Results</a></li>
        <li style="text-decoration:underline;"><a href="/Hospitals/{{$hospital->id}}/Main/OldTests">Previous Test Results</a></li>
    </ul>
</section>

<section>
    <table>
        @if($locations->count() > 0)
            @foreach($locations as $location)
                <tr>
                    <th colspan="3">{{$location->name}}</th>
                </tr>

                @foreach($locationBoards as $board)
                    @if($board->location_id === $location->id)
                        <tr>
                            <td><a href="/Hospitals/Boards/{{$board->id}}">{{$board->name}} <i class="fa-solid fa-arrow-right"></i></a></td>                         
                            <td>{{$board->oldTest->count()}} previous test(s) uploaded</td>                          
                            <td><button onClick="openForm('oldTestForm', {{$board->id}})">Upload test</button></td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        @else
        <tr>
            <th>No Locations Added</th>
        </tr>
        @endif
    </table>
</section>

<div class="hiddenForm" id="oldTestForm" style="display:none;">
    <h2>Upload Old Test</h2>
    <i onClick="closeForm('oldTestForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeOldTest') }}" method="post" enctype="multipart/form-data">
        @include('includes.error')

        <input type="text" name="board_id" id="board_id" class="foreign_id" style="display:none;">
        
        <label for="name">File Name:</label>
        <input type="text" name="name" id="name">

        <label for="file">File Upload:</label>
        <input type="file" name="file" id="file">

        <input type="submit" value="Save">
    </form>
</div>

@endsection