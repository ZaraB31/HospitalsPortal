@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<img src="{{url('/images/auth-logo.png')}}" alt="">

<form method="POST" action="{{ route('login') }}">
    @csrf

    @if ($errors->any())
        <div class="error" id="errorAlert" style="display:block;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <label for="email">Email Address</label>
    <input id="email" type="email" name="email" required autocomplete="email" autofocus>

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required autocomplete="current-password">

    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    <label for="remember">Remember Me</label>

    <input type="submit" value="Login"></input>
</form>
                
@endsection
