@extends('layouts.auth')
@section('content')
<?php //echo "<pre>"; print_r($error)die; ?>
<div class="container-fluid user-login">
  <div class="row">
  <div class="col-md-6 mobile-hide">
    <div class="bg-section">
     <div class="overlay-heading"> <img class="logo-image" src="{{ asset('website/img/logo.png')}}">   
     <h4>GROW YOUR FOOD BUSINESS INTO A WORLD-CLASS BRAND</h4></div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-details">
      <a href="{{url('/')}}"><img src="{{ asset('website/img/logo.png')}}"></a>
        @if(\Session::has('message'))
          <p class="alert alert-info ">
              {{ \Session::get('message') }}
          </p>
        @endif


      <div class="form-heading">
          <h2>Register</h2>
          <p>Register with us! Please enter your details.</p>
      </div>
      <form method="POST" action="{{route('register')}}">
        @csrf
        <div class="form-group">
          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Please enter your name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Please enter your email" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          </div>
          <div class="form-group">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Please enter your password"  name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          </div>
          <div class="form-group">
              <input id="password-confirm" type="password" class="form-control"  placeholder="Please enter your confirm password" name="password_confirmation" required autocomplete="new-password">
          </div>
           <div class="form-group">
              <input type="number" name="mobile_number"  placeholder="Mobile Number" value="{{ old('mobile_number') }}" id="phone" >
          </div>
          <div class="form-group">
              <input type="date" name="date_of_birth"  placeholder="Enter date of birth" value="{{ old('date_of_birth') }}">
               @error('date_of_birth')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          </div>
          <div class="age-check"><input type="checkbox" required></input> I certify that I am at least 18 years old and that I agree to the Terms and Policies
and Privacy Pollcy.</div>
          <button type="submit" class="login-user">Register</button>
           <div class="vendor-signup">
                                <a class="v-signup" href="{{ url('vendor/signup') }}">
                                    Vendor Signup
                                </a>
                                

                            </div>
      </form>
          <div class="or"><p class="or-text">or</p></div>
          <a href="{{url('auth/google')}}" class="login-google"><img src="{{ asset('website/img/google.svg')}}">Log in with Google</a>
          <p class="dont-acc">Already have an account?<a href="{{url('login')}}">Sign in</a></p>
    </div>
  </div>
</div>
</div>
@endsection