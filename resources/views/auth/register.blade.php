@extends('layouts.auth')

@section('form')
    
    <form method="POST" action="/auth/register">
        {!! csrf_field() !!}
        
        <div class="form-group">
            <label for="inName" >Name</label>
            <input type="name" id="inName" name="name" value="{{ old('name') }}" class="form-control">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    
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
            <label for="inPassword_confirmation" >Confirm Password</label>
            <input type="password" name="password_confirmation" id="inPassword_confirmation" class="form-control">
        </div>
    
        <div class="text-center form-group">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
    </form>
@endsection