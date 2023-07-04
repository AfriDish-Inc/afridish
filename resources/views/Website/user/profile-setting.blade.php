@extends('layouts.user')
@section('content')
<script>
  @if(Session::has('message'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('message') }}");
  @endif
</script>
<div class="container testimonials subscription">
    <div class="row">
        <div class="col-md-12">
          <div class="wrapper all-products">
            <h2>Profile Setting</h2>
            </div>

        </div>
      </div>
      </div>
      </div>
<div class="container profile-settings"> 

  <div class="row">
    <div class="col-md-4">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="#home"><img src="{{ asset('website/img/user.svg')}}"> PROFILE SETTING</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="#menu1"><img src="{{ asset('website/img/support.svg')}}"> SUPPORT</a>
        </li> -->
      </ul>
    </div>
  <!-- Tab panes -->
  <div class="col-md-8">
  <div class="tab-content">
    <div id="home" class="container tab-pane active">
        <form class="p-settings" method="POST" action="{{url('profile-setting')}}">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{$userdata->name}}"  required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="mail" name="email" value="{{$userdata->email}}" readonly>
            </div>
            <div class="form-group">
                <label>Mobile Number</label>
                <input type="number" name="mobile_number" value="{{$userdata->mobile_number}}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="Password" name="password" value="" required>
            </div>

            <div id="map" class="form-group">  
                 <input id="pac-input" class="controls" placeholder="Insert the location" value="{{$userdata->address}}" name="address" ame="location" type="text">  
                 <div id="map-canvas"> </div>  
                 <input name="lat" class="lat" value="{{$userdata->latitude}}" type="hidden">  
                 <input name="lon" class="lon" value="{{$userdata->longitude}}" type="hidden">  
            </div>


            
            <div class="update-cancel">
                <button type="submit" class="upd">Update</button>
                <button class="canc">Cancel</button>
            </div>
        </form>
    </div>
    <!-- <div id="menu1" class="container tab-pane fade">
      <form class="p-settings">
        <h4>Support</h4>
            <h5>Send Email To Awesome Support :</h5>
            <div class="form-group">
                <label>Email</label>
                <input type="mail" name="">
            </div>
           
            <div class="update-cancel">
                <button class="upd">Send</button>
                <button class="canc">Cancel</button>
            </div>
        </form>
    </div> -->
  </div>
</div>
</div>
</div>
</div>
@endsection