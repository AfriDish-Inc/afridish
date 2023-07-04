@extends('layouts.user')
@section('content')
<?php //echo "<pre>"; print_r($products); die;  ?>
<script>
  @if(Session::has('message'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('success'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('success') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true 
  }
      toastr.error("{{ session('error') }}");
  @endif
</script>

<div class="container-fluid b-all-products">
  <div class="container testimonials subscription">
    <div class="row">
        <div class="col-md-12">
          <div class="wrapper all-products">
            <h2>Chefs</h2>
            </div>

        </div>
      </div>
      <div class="row">
          <div class="col-md-12">
            <div class="row allproducts vndrs">
              @if(count($chefs) > 0)
                @foreach($chefs as $key=>$vendor)
               
                 <div class="col-md-4">
                  <a href="{{url('vendor-details?id=')}}{{$vendor->id}}"> 
                 <div class="main-frame">
                     <div class="product-thumbnail">
                      <img src="{{ asset('upload/images/')}}/{{$vendor->profile_picture}}">
                       <div class="wish-btn">
                       </div>

                     </div>
                     <div class="product-info vendors">
                         <h4 class="product-title">{{$vendor->name}}</h4>
                     </div>
                 </div>
                 </a>
               </div>
            
            @endforeach
            @else
            <div class="col-md-3">
               <h4 class="product-title" style="color:red;">No Chef Found</h4>
            </div>
            @endif
          </div>
            </div>
          </div>
      </div>
</div>
@endsection