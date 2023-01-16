@extends('layouts.app')

@section('title', 'Home')

@section('content')

@if($user->type_id === 1)
    <section class="createButton">
        <button onClick="openForm('newHospitalForm')">Add New</button>
    </section>
@endif

@if (\Session::has('success'))
    <div class="messageSent">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif

<section class="hospitalsDisplay">
    @foreach($hospitals as $hospital)
    <div>
        <h2>{{$hospital->name}}</h2>
        <button><a href="/Hospitals/{{$hospital->id}}/Main">Main</a></button>
        <button><a href="/Hospitals/{{$hospital->id}}/Community">Community</a></button>
    </div>
    @endforeach
</section>

<div class="hiddenForm" id="newHospitalForm" style="display:none;">
    
    <h2>Add New Hospital</h2>
    <i onClick="closeForm('newHospitalForm')" class="fa-regular fa-circle-xmark"></i>

    <form action="{{ route('storeHospital') }}" method="post">
        @include('includes.error')

        <label for="name">Hospital Name:</label>
        <input type="text" name="name" id="name">

        <input type="submit" value="Save">
    </form>
</div>

@endsection
