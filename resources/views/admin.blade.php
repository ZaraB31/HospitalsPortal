@extends('layouts.app')

@section('title', 'Admin')

@section('content')
@if($user->type_id === 1)

<section style="display:flex;justify-content:space-between;">
    <h1>Admin Dashboard</h1>
    <button><a href="/Hospitals/Admin/Invoices">View Invoices</a></button>
</section>

<section class="splitSection">

    <article class="halfSection">
        <table>
            <tr>
                <th>System Users</th>
                <th style="text-align:right;"><button><a href="/register">Add New</a></button></th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td colspan="2">{{$user->name}}</td>
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
                <td>{{$price->defect}}</td>
                <td>£{{$price->price}}</td>
            </tr>
            @endforeach
        </table>
    </article>

    <article class="halfSection">
        <table>
            <tr>
                <th>User Types</th>
                <th style="text-align:right;"><button>Add New</button></th>
            </tr>
            @foreach($userTypes as $userType)
            <tr>
                <td colspan="2">{{$userType->type}}</td>
            </tr>
            @endforeach
        </table>

        <table>
            <tr>
                <th>Companies</th>
                <th style="text-align:right;"><button>Add New</button></th>
            </tr>
            @foreach($companies as $company)
            <tr>
                <td colspan="2">{{$company->company}}</td>
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
        @include('includes.error')

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