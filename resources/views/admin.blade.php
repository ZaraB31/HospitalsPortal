@extends('layouts.app')

@section('title', 'Admin')

@section('content')
@if($user->type_id === 1 OR $user->type_id === 4)

<section style="display:flex;justify-content:space-between;">
    <h1>Admin Dashboard</h1>
    <button><a href="/Hospitals/Admin/Invoices">View Invoices</a></button>
</section>

@if (\Session::has('success'))
    <div class="messageSent">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif

<section class="splitSection">

    <article class="halfSection">
        <table>
            <tr>
                <th>System Users</th>
                <th style="text-align:right;"><button><a href="/register">Add New</a></button></th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->company->company}}</td>
            </tr>
            @endforeach
        </table>

        <table>
            <tr>
                <th>Defects</th>
                <th style="text-align:right;"><button onClick="openForm('newDefectForm', 0)">Add New</button></th>
            </tr>
            @foreach($prices as $price)
            <tr>
                <td>{{$price->defect}}  <i onClick="editDefectForm('editDefectForm', {{$price->id}}, '{{$price->defect}}', {{$price->price}})" class="fa-regular fa-pen-to-square"></i></td>
                <td>£{{$price->price}}</td>
            </tr>
            @endforeach
        </table>
    </article>

    <article class="halfSection">
        <table>
            <tr>
                <th>User Types</th>
            </tr>
            @foreach($userTypes as $userType)
            <tr>
                <td>{{$userType->type}}</td>
            </tr>
            @endforeach
        </table>

        <table>
            <tr>
                <th>Companies</th>
            </tr>
            @foreach($companies as $company)
            <tr>
                <td>{{$company->company}}</td>
            </tr>
            @endforeach
        </table>
    </article>
</section>

<div class="hiddenForm" id="newDefectForm" style="display:none;">
    <h2>New Defect</h2>
    <i onClick="closeForm('newDefectForm')" class="fa-regular fa-circle-xmark"></i>
    <p>When entering the price, please do not use a pound sign (£), and round the value to two decimal places.</p>

    <form action="{{ route('storeDefect') }}" method="post" enctype="multipart/form-data">
        @include('includes.error', ['form' => 'newDefect'])

        <label for="defect">Defect Name:</label>
        <input type="text" name="defect" id="defect">

        <label for="price">Price:</label>
        <input type="text" name="price" id="price">

        <input type="submit" value="Save">
    </form>
</div>

<div class="hiddenForm" id="editDefectForm" style="display:none;">
    <h2>Edit Defect</h2>
    <i onClick="closeForm('editDefectForm')" class="fa-regular fa-circle-xmark"></i>
    <p>When entering the price, please do not use a pound sign (£), and round the value to two decimal places.</p>

    <form action="{{ route('editDefect') }}" method="post" enctype="multipart/form-data">
        @include('includes.error', ['form' => 'editDefect'])

        <input type="text" name="price_id" id="price_id" style="display:none;">

        <label for="defect">Defect Name:</label>
        <input type="text" name="defect" id="defect">

        <label for="price">Price:</label>
        <input type="text" name="price" id="price">

        <input type="submit" value="Save">
    </form>
</div>

@else
<section>
    <h1 style="text-align:center;">Sorry you do not have access to this page</h1>
</section>
@endif
@endsection