@extends('layouts.app')

@section('title', 'Remedial Works - Create')

@section('content')

<section>
    <a href="/Hospitals/Board/Remedials"><i class="fa-solid fa-arrow-left"></i> Back</a>
</section>

<section>
    <h1>Remedial Works</h1>
</section>

<section>
    <form action="{{ route('storeRemedial') }}" class="createForm" method="post" enctype="multipart/form-data">
        @include('includes.error', ['form' => 'newRemedial'])

        <label for="hospital">Hospital:</label>
        <select name="hospital" id="hospital" class="hospital">
            <option value="">Select...</option>
            @foreach($hospitals as $hospital)
            <option value="{{$hospital->id}}">{{$hospital->name}}</option>
            @endforeach
        </select>
        
        <label for="location">Location:</label>
        <select name="location" id="location" class="location">
            <option value="">Select...</option>
            @foreach($locations as $location)
            <option class="location hidden location{{$location->hospital_id}}" value="{{$location->id}}">{{$location->name}}</option>
            @endforeach
        </select>

        <label for="board_id">Board:</label>
        <select name="board_id" id="board_id" class="board">
            <option value="">Select...</option>
            @foreach($boards as $board)      
            <option  class="board hidden board{{$board->location_id}}" value="{{$board->id}}">{{$board->name}}</option>
            @endforeach
        </select>

        <label for="circuitNo">Circuit Number:</label>
        <input type="text" name="circuitNo" id="CircuitNo">

        <label for="room">Room Name/Number:</label>
        <input type="text" name="room" id="room">

        <label for="defects[]">Defect(s):</label>
        <div class="checkboxContainer">
            @foreach($prices as $price)
            <div class="checkbox">
                <input type="checkbox" name="defect[]" id="defect" value="{{$price->id}}">
                <label for="defect">{{$price->defect}}</label>
            </div>
            @endforeach
        </div>

        <label for="images">Picture(s) of defect:</label>
        <input type="file" name="images[]" id="images" multiple>

        <label for="description">Description:</label>
        <textarea name="description" id="description"></textarea>

        <label for="estimatedCompletion">Estimated Completion Date:</label>
        <input type="datetime-local" name="estimatedCompletion" id="estimatedCompletion">  
        
        <input type="submit" value="Submit">
    </form>
</section>

<script>
    $(document).ready(function() {
        $("select.hospital").change(function() {
            var selectedHospital = $(this).children("option:selected").val();
            $(".hidden.location").hide();
            $(".location" + selectedHospital).show();
        });
        $("select.location").change(function() {
            var selectedLocation = $(this).children("option:selected").val();
            $(".hidden.board").hide();
            $(".board" + selectedLocation).show();
        });
    });
</script>

@endsection