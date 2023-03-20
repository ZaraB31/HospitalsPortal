@extends('layouts.app')

@section('title', 'Main')

@section('content')

@if($user->type_id === 1 OR $user->type_id === 4)
    <button class="createButton" onClick="openForm('newLocationForm', '{{$hospital->id}}')"><i class="fa-solid fa-plus"></i></button>
@endif

<section>
    <a href="/Hospitals"><i class="fa-solid fa-arrow-left"></i> Back</a>
</section>

<section>
    <h1>{{$hospital->name}} - Main</h1>
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
    <table>
        <tr>
            <th colspan="3">Locations</th>
        </tr>
        @if($locations->count() > 0)
            @foreach($locations as $location)
            <tr>
                <td><a href="/Hospitals/Location/{{$location->id}}">{{$location->name}}  <i class="fa-solid fa-arrow-right"></i></a></td>
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
    <h2>{{$hospital->name}} - Add New Main Location</h2>
    <i onClick="closeForm('newLocationForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeLocation') }}" method="post">
        @include('includes.error', ['form' => 'newLocation'])

        <input type="number" name="hospital_id" id="hospital_id" class="foreign_id" style="display:none;">

        <label for="name">Location Name:</label>
        <input type="text" name="name" id="name">

        <input type="text" name="type" id="type" value="main" style="display:none;">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="newTestForm" style="display:none;">
    <h2>Upload Test</h2>
    <i onClick="closeForm('newTestForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeTest') }}" method="post" enctype="multipart/form-data">
        @include('includes.error', ['form' => 'newTest'])

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

<div class="hiddenForm" id="search" style="display:none;">
    <h2>Search Locations</h2>
    <i onClick="closeForm('search')" class="fa-regular fa-circle-xmark"></i>

    <input type="text" id="search" name="search">

    <ul id="results"></ul>
</div>

<script>
    $(document).on('keyup', '#search', function(){
        var query = $(this).val();
        $.ajax({
            url:"{{ route('MainSearch') }}",
            method:'GET',
            data:{query:query},
            dataType:'json',
            success:function(data)
            {
                $('ul#results').html(data);
            }
        })
    });
</script>


@endsection