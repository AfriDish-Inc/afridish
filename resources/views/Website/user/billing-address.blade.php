@extends('layouts.user')
@section('content')
<?php //echo "<pre>"; print_r($cartdata); die; ?>
<div class="container testimonials subscription">
    <div class="row">
        <div class="col-md-12">
          <div class="wrapper all-products">
            <h2>Billing Address</h2>
            </div>

        </div>
      </div>
      </div>
      </div>
     
<div class="container shopping-cart">
<script>
  @if(Session::has('message'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('message') }}");
  @endif
  @if(Session::has('errors'))
  toastr.options = 
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.error("{{ session('errors') }}");
  @endif
</script>
  <div class="row">
    <div class="col-md-3">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link " href="{{url('shoping-cart')}}"><img src="{{ asset('website/img/cart-c.svg')}}"> CART</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="{{url('billing-address')}}"><img src="{{ asset('website/img/user.svg')}}"> BILLING ADDRESS</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('checkout')}}"><img src="{{ asset('website/img/support.svg')}}"> CHECKOUT</a>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="{{url('order-history')}}"><img src="{{ asset('website/img/o-history.svg')}}"> ORDER HISTORY</a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="{{url('order-history')}}"><img src="{{ asset('website/img/saved.svg')}}"> SAVED ADDRESSES</a>
    </li> -->
  </ul>
</div>
  <!-- Tab panes -->
  <div class="col-md-9">
  <div class="tab-content">
    <div id="billing-address" class="container tab-pane active">
      <div class="my-wishlist billing-address">
        <p class="billing-heading">Billing Address</p>
        <form class="bill-form" action="{{'save-address'}}" method="POST">
          @csrf
          <div class="felx-fields">
            <div class="form-group">
              <label>First Name*</label>
              <input type="text" name="first_name" placeholder="Please Enter First name" required>
            </div>
            <div class="form-group">
              <label>Last Name*</label>
              <input type="text" name="last_name" placeholder="Please  Enter Last name" required>
            </div>
          </div>
          <div class="felx-fields">
            <div class="form-group state">
              <label>Email*</label>
              <input type="mail" name="email" placeholder="Please  Enter Email" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+$" required>
            </div>
          </div>
          <div class="felx-fields">
            <div class="form-group street">
              <label>Street Address*</label>
              <input type="text" name="address1" placeholder="Please  Enter address" required> &nbsp;&nbsp; 
              <input type="text" name="address2" placeholder="Please  Enter address">
            </div>
          </div>
          <div class="felx-fields">
            <div class="form-group">
              <label>State/Province*</label>
              <input type="text" name="state" placeholder="Please  Enter State Name" required>
            </div>
            <div class="form-group">
              <label>City*</label>
              <input type="text" name="city" placeholder="Please  Enter City Name" required>
            </div>
          </div>
          <div class="felx-fields">
            <div class="form-group">
              <label>Zip/Postal Code*</label>
              <input type="number" name="zip_code" placeholder="Please  Enter Zip Code" required> 
            </div>
            <div class="form-group">
              <label>Phone*</label>
              <input type="number" name="mobile_number" placeholder="Please  Enter Phone No" required>
            </div>
          </div>
          <div class="checkbox-set">
            <div class="filter">
              <div class="form-group">
                <input type="checkbox" id="x">
                <label for="x">My billing and shipping address are the same</label>
              </div>
            </div>
          </div>
          <button  type="submit" class="upd">Proceed To Checkout</button>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
</div>
</div>
@endsection