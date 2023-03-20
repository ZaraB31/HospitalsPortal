@extends('layouts.app')

@section('title', 'Community')

@section('content')

@if($user->type_id === 1 OR $user->type_id === 4)
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

@if (\Session::has('delete'))
    <div class="noAccess">
        <ul>
            <li>{!! \Session::get('delete') !!}</li>
        </ul>
    </div>
@endif

<section>
    <h1>{{$hospital->name}} - Community</h1>
</section>

<section>
    <table>
        <tr>
            <th colspan="3">Locations</th>
        </tr>
        @if($locations->count() > 0)
            @foreach($locations as $location)
            <tr>
                <td><a href="/Hospitals/Location/{{$location->id}}">{{$location->name}} <i class="fa-solid fa-arrow-right"></i></a></td>
                @if($location->hospital->name === 'Ysbyty Gwynedd')
                <td>{{count($locationBoards)}} Board(s)</td>
                <td>{{count($locationDrawings)}} Drawing(s)</td>
                @else
                <td colspan="2">{{count($locationBoards)}} Board(s)</td>
                @endif
            </tr>
            @endforeach
        @else 
            <tr>
                <td>No Locations added yet</td>
            </tr>
        @endif
    </table>
</section>

<div class="hiddenForm" id="newLocationForm" style="display:none;">
    <h2>{{$hospital->name}} - Add New Community Location</h2>
    <i onClick="closeForm('newLocationForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeLocation') }}" method="post">
        @include('includes.error', ['form' => 'newLocation'])

        <input type="number" name="hospital_id" id="hospital_id" class="foreign_id" style="display:none;">

        <label for="name">Location Name:</label>
        <input type="text" name="name" id="name">

        <input type="text" name="type" id="type" value="community" style="display:none;">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="newBoardForm" style="display:none;">
    <h2>Add New Board</h2>
    <i onClick="closeForm('newBoardForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeBoard') }}" method="post">
        @include('includes.error', ['form' => 'newBoard'])
        <input type="text" name="location_id" id="location_id" class="foreign_id"  style="display:none;">

        <label for="name">Board Name:</label>
        <input type="text" name="name" id="name">

        <input type="submit" value="Save">
    </form>
</div>

@endsection