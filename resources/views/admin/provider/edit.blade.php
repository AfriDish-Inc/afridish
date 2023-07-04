@extends('layouts.admin')
@section('content')

<?php //echo "<pre>"; print_r($dailyhours); die; ?>
<div class="card">
     @if($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card-header">
        {{ trans('global.edit') }} Vendor
    </div>
 
    <div class="card-body card-custom">
        <form action="{{ route("admin.provider.update", [$provider->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="stor-frm-otr  d-block vendor_from">
            <div class="row ">
                <div class="col-md-6 mb-3">
                    <div class="form-group w-100 {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Vendor {{ trans('cruds.user.fields.name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($provider) ? $provider->name : '') }}" required>
                        @if($errors->has('name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.user.fields.name_helper') }} 
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group w-100 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">Email*</label>
                        <input type="text" id="email" name="email" class="form-control" value="{{ old('email', isset($provider) ? $provider->email : '') }}" required readonly>
                        @if($errors->has('email'))
                            <em class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.user.fields.name_helper') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group w-100 {{ $errors->has('mobile_number') ? 'has-error' : '' }}">
                        <label for="mobile_number">Mobile Number*</label>
                        <input type="text" id="mobile_number" name="mobile_number" class="form-control" value="{{ old('mobile_number', isset($provider) ? $provider->mobile_number : '') }}" required>
                        @if($errors->has('mobile_number'))
                            <em class="invalid-feedback">
                                {{ $errors->first('mobile_number') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.user.fields.name_helper') }}
                        </p>
                    </div>
                </div>
                @if(Auth::user()->vendor_category_id == 1)
                <div class="col-md-6 mb-3">
                    <div class="form-group w-100 {{ $errors->has('user_address') ? 'has-error' : '' }}">
                        <label for="user_address">Address*</label>
                        <input type="text" id="user_address" name="user_address" class="form-control" value="{{ old('user_address', isset($provider) ? $provider->user_address : '') }}" >
                        @if($errors->has('user_address'))
                            <em class="invalid-feedback">
                                {{ $errors->first('user_address') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.user.fields.name_helper') }}
                        </p>
                    </div>
                </div>
                @endif
                <div class="col-md-6 mb-3">
                    <div class="form-group w-100 select-prdct">   
                        <label for="category">Category Name*</label>
                        <div class="select_arrow">
                            <i class=" fa fa-angle-left"></i>
                            <select id="vendor_category_id" name="vendor_category_id" required>   
                                    <option value=""> -- Select Category -- </option>   
                                @foreach($vendorCategories as $category)
                                    <option value="{{ $category->id }}" {{ $provider->vendor_category_id == $category->id ? 'selected' : '' }} >{{ $category->category_name }}</option>
                                @endforeach
                            </select>            
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-4 pb-2">
                    <div class="date-group w-100">
                        <?php if($dailyhours){
                                if($dailyhours->sun){
                                   $sun =  explode('|', $dailyhours->sun);
                                   $sunstart = $sun[0];
                                   $sunend = $sun[1];
                                }else{
                                   $sunstart = "";
                                   $sunend = "";
                                }
                                if($dailyhours->mon){
                                   $mon =  explode('|', $dailyhours->mon);
                                   $monstart = $mon[0];
                                   $monend = $mon[1];
                                }else{
                                   $monstart = "";
                                   $monend = "";
                                }
                                if($dailyhours->tue){
                                   $tue =  explode('|', $dailyhours->tue);
                                   $tuestart = $tue[0];
                                   $tueend = $tue[1];
                                }else{
                                   $tuestart = "";
                                   $tueend = "";
                                }
                                if($dailyhours->wed){
                                   $wed =  explode('|', $dailyhours->wed);
                                   $wedstart = $wed[0];
                                   $wedend = $wed[1];
                                }else{
                                   $wedstart = "";
                                   $wedend = "";
                                }
                                if($dailyhours->thu){
                                   $thu =  explode('|', $dailyhours->thu);
                                   $thustart = $thu[0];
                                   $thuend = $thu[1];
                                }else{
                                   $thustart = "";
                                   $thuend = "";
                                }
                                if($dailyhours->fri){
                                   $fri =  explode('|', $dailyhours->fri);
                                   $fristart = $fri[0];
                                   $friend = $fri[1];
                                }else{
                                   $fristart = "";
                                   $friend = "";
                                }
                                if($dailyhours->sat){
                                   $sat =  explode('|', $dailyhours->sat);
                                   $satstart = $sat[0];
                                   $satend = $sat[1];
                                }else{
                                   $satstart = "";
                                   $satend = "";
                                }
                        }  ?>
                        <div class="date_row position-relative">
                            <div class="date_label">
                                <h5>Start Time</h5>
                                <h5>End Time</h5>
                            </div>
                            <div class="sunday"> 
                                <label >Sun</label>
                                <span>
                                    <input type="time" id="sun_start_date" name="sun_start_date" class="form-control" value="{{ old('sun_start_date' ,$sunstart ?? '')}}">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                <span>
                                    <input type="time" id="sun_end_date" name="sun_end_date" class="form-control" value="{{ old('sun_end_date' , $sunend ?? '')}}">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                            </div>
                            <div class="sunday"> 
                                <label >Mon</label>
                                <span>
                                    <input type="time" id="mon_start_date" name="mon_start_date" class="form-control" value="{{ old('mon_start_date', $monstart ?? '' ) }}">
                                     <i class="fa fa-clock-o"></i>
                                </span>
                                <span>
                                    <input type="time" id="mon_end_date" name="mon_end_date" class="form-control" value="{{ old('mon_end_date' ,  $monend ?? '' )}}">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                            </div>
                            <div class="sunday"> 
                                <label >Tue</label>
                                <span>
                                    <input type="time" id="tue_start_date" name="tue_start_date" class="form-control" value="{{ old('tue_start_date', $tuestart ?? '')}}">
                                     <i class="fa fa-clock-o"></i>
                                </span>
                                <span>
                                    <input type="time" id="tue_end_date" name="tue_end_date" class="form-control" value="{{ old('tue_end_date' , $tueend  ?? '' )}}">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                            </div>
                            <div class="sunday"> 
                                <label >Wed</label>
                                <span>
                                    <input type="time" id="wed_start_date" name="wed_start_date" class="form-control" value="{{ old('wed_start_date' , $wedstart ?? '' )}}">
                                     <i class="fa fa-clock-o"></i>
                                </span>
                                <span>
                                    <input type="time" id="wed_end_date" name="wed_end_date" class="form-control" value="{{ old('wed_end_date',  $wedend ?? '' )}}">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                            </div>
                            <div class="sunday"> 
                                <label >Thu</label>
                                <span>
                                    <input type="time" id="thu_start_date" name="thu_start_date" class="form-control" value="{{ old('thu_start_date', $thustart ?? '' )}}">
                                     <i class="fa fa-clock-o"></i>
                                </span>
                                <span>
                                    <input type="time" id="thu_end_date" name="thu_end_date" class="form-control" value="{{ old('thu_end_date' , $thuend ?? '' )}}">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                            </div>
                            <div class="sunday"> 
                                <label >Fri</label>
                                <span>
                                    <input type="time" id="fri_start_date" name="fri_start_date" class="form-control" value="{{ old('fri_start_date' , $fristart ?? '' )}}">
                                     <i class="fa fa-clock-o"></i>
                                </span>
                                <span>
                                    <input type="time" id="fri_end_date" name="fri_end_date" class="form-control" value="{{ old('fri_end_date',  $friend ?? '' )}}">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                            </div>
                            <div class="sunday"> 
                                <label >Sat</label>
                                <span>
                                    <input type="time" id="sat_start_date" name="sat_start_date" class="form-control" value="{{ old('sat_start_date', $satstart ?? '' )}}">
                                     <i class="fa fa-clock-o"></i>
                                </span>
                                <span>
                                    <input type="time" id="sat_end_date" name="sat_end_date" class="form-control" value="{{ old('sat_end_date', $satend ?? '' )}}">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div>
                        <div class="form-group {{ old('sun_end_date') , $errors->has('profile_picture') ? 'has-error' : '' }}">
                        <label for="detail">Profile Picture*</label>
                        <div class="uplad-img">
                        <input type="file" id="profile_picture" accept="image/png,  image/jpeg" name="profile_picture" class="form-control" value="{{ old('profile_picture') }}" required>
                        @if($errors->has('profile_picture'))
                            <em class="invalid-feedback">
                                {{ $errors->first('profile_picture') }}
                            </em>
                        @endif
                       </div>
                    </div>
                    </div>
                </div>
            </div>
		</div>	
	
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection