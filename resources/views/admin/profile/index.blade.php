@extends('layouts.admin')
@section('content')


<div class="row">
    <div class="col-md-6 col-12 border-right-dark ">
        <div class="edit-profile">
            <div class="row">
                <div class="col-12 mb-1"><h2>Update Profile</h2></div>
                <div class="col-12">
                 @if(Auth::user()->user_type == "V")
                 <form action="{{ route("vendor.updateProfile") }}" method="POST" enctype="multipart/form-data">
                 @else
                 <form action="{{ route("admin.updateProfile") }}" method="POST" enctype="multipart/form-data">
                 @endif   
        
                    @csrf
                    <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                      <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" placeholder="Enter name" required>
                    </div>
                    <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                      <input type="text" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" placeholder="Enter Email" required readonly>
                    </div>
            
                    <div id="map" class="form-group">  
                        <label for="exampleInputEmail1">Address</label>
                         <input id="pac-input" class="form-control" placeholder="input the location" value="{{Auth::user()->address}}" name="address" ame="location" type="text">  
                         <div id="map-canvas"> </div>  
                         <input name="lat" class="lat" value="{{Auth::user()->latitude}}" type="hidden">  
                         <input name="lon" class="lon" value="{{Auth::user()->longitude}}" type="hidden">  
                    </div>
                    <div class="form-group">
                    <label for="exampleInputPassword1">Image</label>
                    <input type="file" id="image" accept="image/png, image/jpeg" name="image" class="form-control" value="" required>
                    </div>

                    <button type="submit" class="btn btn-danger">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="col-md-6 col-12">
    <div class="change-password">
        <div class="row">
            <div class="col-12 mb-1"><h2>Update Password</h2></div>
            <div class="col-12">
                <form action="{{ route("admin.updatePassword") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Old password</label>
                        <input type="password" class="form-control" id="exampleInputEmail1" name="old_password" placeholder="Enter old password" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">New password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="new_password" placeholder="Enter new password" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm new password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="confirm_password" placeholder="Enter confirm password" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Update Password</button>
              </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection