@extends('layouts.auth')
@section('content')
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
      <a href="{{url('/admin/login')}}"><img src="{{ asset('website/img/logo.png')}}"></a>
        @if(\Session::has('message'))
          <p class="alert alert-info ">
              {{ \Session::get('message') }}
          </p>
        @endif


      <div class="form-heading">
          <h2>Vendor Signup</h2>
          <p>Signup with us! Please enter your details.</p>
      </div>
      <form method="POST" action="{{url('vendor/signup')}}">
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
              <input type="date" name="date_of_birth"  placeholder="Enter date of birth" value="{{ old('date_of_birth') }}" required>
               @error('date_of_birth')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          </div>

          <!-- <div class="form-group">
             <select id="vendor_type" name="vendor_type" required>   
                <option value=""> -- Select Vendor Type -- </option>   
                @foreach($vendorCategories as $category)
                <option value="{{ $category->id }}" >{{ $category->category_name }}</option>
                @endforeach
            </select>  
          </div> -->

          <div class="form-group">
             <select id="user_type" name="user_type" required>   
                <option value=""> -- Select Brand Type -- </option>   
                <option value="V" >Vendor</option>
                <option value="R" >Restaurant</option>
                <option value="CH" >Chef</option>
            </select>  
          </div>

          <div class="address" style="display:none;">
            <div class="form-group">
                <div id="map" class="form-group"> 
                     <input id="pac-input" class="form-control" placeholder="input the location" value="" name="address" ame="location" type="text">  
                     <div id="map-canvas"> </div>  
                     <input name="lat" class="lat" value="" type="hidden">  
                     <input name="lon" class="lon" value="" type="hidden">  
                </div>
            </div>   
          </div>   

          <div class="age-check"><input type="checkbox" required style="width:20px"></input> I certify that I am at least 18 years old and that I agree to the Terms and Policies  and Privacy Pollcy.</div>
          <button type="submit" class="login-user">Register</button>
      </form>
          <p class="dont-acc">Already have an account?<a href="{{url('admin/login')}}">Sign in</a></p>
    </div>
  </div>
</div>
</div>
@endsection