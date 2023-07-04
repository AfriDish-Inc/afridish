@extends('layouts.auth')
@section('content')
<script>
  @if(Session::has('status'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('status') }}");
  @endif
</script>
<div class="container-fluid user-login">
  <div class="row">
  <div class="col-md-6 mobile-hide">
    <div class="bg-section">
    <img class="bg-image" src="{{ asset('website/img/background.png')}}">
     <div class="overlay-heading"><!-- <h4>Welcome To Home of Cannabis</h4> -->
      <p>WELCOME TO HOME OF AFRICAN DISHES</p></div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-details">
      <a href="{{url('/')}}"><img src="{{ asset('website/img/logo.png')}}"></a>
      <div class="form-heading">
          <h2>Reset Your Password</h2>
          <p>Enter the email address associated with your account and we'll send you a link to reset your password.</p>
      </div>
      <form method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}          
        <div class="form-group">
              <input name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus placeholder="Email" value="{{ old('email', null) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
          </div>
          <button type="submit" class="btn btn-primary px-4 login-user">Reset Password</button>
          <p class="dont-acc">Don't have an account?<a href="{{url('register')}}">Sign up for free</a></p>
      </form>
    </div>
  </div>
</div>
</div>

@endsection  