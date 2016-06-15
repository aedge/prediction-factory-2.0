@extends('layouts.auth')

@section('form')
    <form method="POST" action="/auth/login">
        {!! csrf_field() !!}
    
        <div class="form-group">
            <label for="inEmail" >Email</label>
            <input type="email" id="inEmail" name="email" value="{{ old('email') }}" class="form-control">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    
        <div class="form-group">
            <label for="inPassword" >Password</label>
            <input type="password" name="password" id="inPassword" class="form-control">
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    
        <div class="form-group">
            <input type="checkbox" name="remember" id="chkRemember" > 
            <label for="chkRemember" >Remember Me</label>
        </div>
    
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </div>
    
        <br/>
        <div class="text-center">
            <p> Not yet a member? </p>
        </div>
        
        <div class="text-center">
            <a class="btn btn-default btn-block" href="{{ url('/auth/register') }}">Register</a>
        </div>
    </form>
@endsection
