@extends('layouts.auth')
@section('content')
<div class="container-fluid user-login">
  <div class="row">
  <div class="col-md-6 mobile-hide">
    <div class="bg-section">
     <div class="overlay-heading">
     <img class="logo-image" src="{{ asset('website/img/logo.png')}}">   
     <h4>GROW YOUR FOOD BUSINESS INTO A WORLD-CLASS BRAND</h4></div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-details">
      @if(\Session::has('message'))
          <p class="alert alert-info ">
              {{ \Session::get('message') }}
          </p>
      @endif
      <a href="{{url('/')}}"><img src="{{ asset('website/img/logo.png')}}"></a>
      <div class="form-heading">
          <h2>Login</h2>
          <p>Welcome back! Please enter your details.</p>
      </div>
      <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
          <div class="form-group">
              <!-- <input type="mail" name="" placeholder="Email"> -->
              <input name="email" type="text" required  placeholder="Email" value="{{ old('email', null) }}">
              @if($errors->has('email'))
                  <div class="invalid-feedback">
                      {{ $errors->first('email') }}
                  </div>
              @endif
          </div> 
          <div class="form-group">
             <input name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="Password">
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
          </div>
          <div class="forgot-password">
              <div class="left">
                  <input type="checkbox" name="">Remember for 30 days
              </div>
              <div class="right">
                  <a href="{{ route('password.request') }}">Forgot Password</a>
              </div>
          </div>

          <button type="submit" class="login-user">Login</button>
          
      </form>
          <a href="{{url('/register')}}" class="register-user">Register</a>
          <div class="or"><p class="or-text">or</p></div>
          <a href="{{url('auth/google')}}" class="login-google"><img src="{{ asset('website/img/google.svg')}}">Log in with Google</a>
          <p class="dont-acc">Don't have an account?<a href="{{url('/register')}}">Sign up for free</a></p>
    </div>
  </div>
</div>
</div>
@endsection