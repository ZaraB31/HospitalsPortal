@extends('layouts.app')

@section('title', 'Home')

@section('content')

@if($user->type_id === 1)
    <section class="createButton">
        <button onClick="openForm('newLocationForm')">Add New Location</button>
    </section>
@endif

@if (\Session::has('success'))
    <div class="messageSent">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif

<h1>{{$hospital->name}} - Main</h1>

<section>
    <table>
        @if($locations->count() > 0)
        @foreach($locations as $location)
        <tr>
            <th>{{$location->name}}</th>
            <th style="text-align:right;">
                @if($user->type_id === 1)
                <button onClick="openTable('{{$location->id}}-tableForm')">Add DB</button>
                @endif
            </th>
        </tr>
        <tr id="{{$location->id}}-tableForm" style="display:none;">
            <td colspan="2">
                <form action="{{ route('storeBoard') }}" method="post">
                    @include('includes.error')
                    <input type="text" name="location_id" id="location_id" value="{{$location->id}}" style="display:none;">

                    <label for="name">Board Name:</label>
                    <input type="text" name="name" id="name">

                    <input type="submit" value="Save">
                </form>
            </td>
        </tr>
            @foreach($locationBoards as $board)
            @if($board->location_id === $location->id)
            <tr>
                <td>{{$board->name}}</td>
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

        <input type="number" name="hospital_id" id="hospital_id" value="{{$hospital->id}}" style="display:none;">

        <label for="name">Location Name:</label>
        <input type="text" name="name" id="name">

        <input type="text" name="type" id="type" value="main" style="display:none;">

        <input type="submit" value="Save">
    </form>
</div>
@endsection