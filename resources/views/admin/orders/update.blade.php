@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Order status
    </div>

    <div class="card-body card-custom">
        @if(auth()->user()->user_type == "A")
          <form action="#" method="POST" enctype="multipart/form-data">
         @elseif(auth()->user()->user_type == "V")   
           <form action="{{ url('vendor/update-order')}}" method="POST" enctype="multipart/form-data">
        @endif
            @csrf
        <input type="hidden" name="order_id" value="{{ Request::get('id') }}">
        <div class="stor-frm-otr">
            <div class="form-group select-prdct">   
                <label for="category">Status *</label>
                <select name="status" required> 
                        <option value=""> -- Select Status -- </option>   
                        <option value="0" @if($order_details->order_status == 0) selected @else @endif>Pending</option>
                        <option value="1" @if($order_details->order_status == 1) selected @else @endif>Processing</option>
                        <option value="2" @if($order_details->order_status == 2) selected @else @endif>Delivered</option>
                </select>
            </div>
        </div>
	
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection