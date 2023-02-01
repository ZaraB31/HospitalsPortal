@extends('layouts.app')

@section('title', 'Register')

@section('content')
<section>
        <h1>Register New User</h1>
</section>
<section>
        <form method="POST" action="{{ route('register') }}">
                @include('includes.error')

                <label for="name" >Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
        
                <label for="email" >Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>

                <label for="phone">Phone Number:</label>
                <input type="number" name="phone" id="phone" required>

                <label for="type_id">User Type:</label>
                <select name="type_id" id="type_id">
                        <option value="">Select...</option>
                        @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->type}}</option>
                        @endforeach
                </select>

                <label for="company_id">Company:</label>
                <select name="company_id" id="Company_id">
                        <option value="">Select...</option>
                        @foreach($companies as $company)
                        <option value="{{$company->id}}">{{$company->company}}</option>
                        @endforeach
                </select>

                <label for="password" >Password</label>
                <input id="password" type="password" name="password" required >
        
                <label for="password-confirm" >Confirm Password</label>
                <input id="password-confirm" type="password"  name="password_confirmation" required >

                <input type="submit" value="Register" ></input>
        </form>
</section>
@endsection
