@extends('layouts.app')

@section('title', 'Main')

@section('content')

@if($user->type_id === 1)
    <button class="createButton" onClick="openForm('newLocationForm', '{{$hospital->id}}')"><i class="fa-solid fa-plus"></i></button>
@endif

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


<section>
    <table>
        @if($locations->count() > 0)
            @foreach($locations as $location)
                <tr>
                    <th>{{$location->name}}</th>
                    <th colspan="2" style="text-align:right;">
                        @if($user->type_id === 1 OR $user->type_id === 2)
                        <button onClick="openForm('newBoardForm', '{{$location->id}}')">Add DB</button>
                        @endif
                    </th>
                </tr>

                @foreach($locationBoards as $board)
                    @if($board->location_id === $location->id)
                        <tr>
                            <td><a href="/Hospitals/Boards/{{$board->id}}">{{$board->name}} <i class="fa-solid fa-arrow-right"></i></a></td>
                            @if($board->test === null)
                                <td colspan="2">
                                    No Test Uploaded
                                    @if($user->type_id === 1 OR $user->type_id === 2)
                                        <button onClick="openForm('newTestForm', '{{$board->id}}')">Upload Test</button>
                                    @endif
                                </td>
                            @else
                                @if($board->test->result === "Satisfactory")
                                        <td style="background-color: #1FC01D;">Circuits: {{$board->test->circuits}}</td>
                                        <td colspan="2" style="background-color: #1FC01D;">{{$board->test->result}}</td>
                                @elseif($board->test->result === "Unsatisfactory")
                                    <td style="background-color: #C01D1F; color:white;">Circuits: {{$board->test->circuits}}</td>
                                    <td style="background-color: #C01D1F; color:white;">{{$board->test->result}}</td>
                                @endif
                            @endif
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

<div class="hiddenForm" id="newLocationForm" style="display:none;">
    <h2>{{$hospital->name}} - Add New Main Location</h2>
    <i onClick="closeForm('newLocationForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeLocation') }}" method="post">
        @include('includes.error')

        <input type="number" name="hospital_id" id="hospital_id" class="foreign_id" style="display:none;">

        <label for="name">Location Name:</label>
        <input type="text" name="name" id="name">

        <input type="text" name="type" id="type" value="main" style="display:none;">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="newBoardForm" style="display:none;">
    <h2>Add New Board</h2>
    <i onClick="closeForm('newBoardForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeBoard') }}" method="post">
        @include('includes.error')
        <input type="text" name="location_id" id="location_id" class="foreign_id"  style="display:none;">

        <label for="name">Board Name:</label>
        <input type="text" name="name" id="name">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="newTestForm" style="display:none;">
    <h2>Upload Test</h2>
    <i onClick="closeForm('newTestForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeTest') }}" method="post" enctype="multipart/form-data">
        @include('includes.error')

        <input type="text" name="board_id" id="board_id" class="foreign_id" style="display:none;">
        
        <label for="name">File Name:</label>
        <input type="text" name="name" id="name">

        <label for="file">File Upload:</label>
        <input type="file" name="file" id="file">

        <label for="circuits">Number of Circuits:</label>
        <input type="number" name="circuits" id="circuits">

        <label for="result">Result:</label>
        <select name="result" id="result">
            <option value="">Select...</option>
            <option value="Satisfactory">Satisfactory</option>
            <option value="Unsatisfactory">Unsatisfactory</option>
        </select>

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="newRemedialForm" style="display:none;">
    <h2>Add New Remedial</h2>
    <i onClick="closeForm('newRemedialForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeRemedial') }}" method="post" enctype="multipart/form-data">
        @include('includes.error')

        <input type="text" name="test_id" id="test_id" class="foreign_id" style="display:none;">
        
        <label for="circuitNo">Circuit Number:</label>
        <input type="text" name="circuitNo" id="circuitNo">

        <label for="room">Room</label>
        <input type="text" name="room" id="room">

        <label for="description">Description</label>
        <textarea name="description" id="description"></textarea>

        <label for="images[]">Photos:</label>
        <input type="file" name="images[]" id="images" multiple>

        <input type="submit" value="Save">
    </form>
</div>
@endsection