@extends('layouts.user')
@section('content')
<div class="container testimonials subscription">
    <div class="row">
        <div class="col-md-12">
          <div class="wrapper all-products">
            <h2>Order Placed</h2>
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
</script>
  <div class="row">
    <div class="col-md-3">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" href="{{url('shoping-cart')}}"><img src="{{ asset('website/img/cart-c.svg')}}"> CART</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('billing-address')}}"><img src="{{ asset('website/img/user.svg')}}"> BILLING ADDRESS</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('checkout')}}"><img src="{{ asset('website/img/support.svg')}}"> CHECKOUT</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('order-history')}}"><img src="{{ asset('website/img/o-history.svg')}}"> ORDER HISTORY</a>
    </li>
  </ul>
</div>
  <!-- Tab panes -->
  <div class="col-md-9">
  
  <h4>Your order plased successfully !</h4>
 <h4>Order Id : {{$data}}</h4>
 <a  class="btn btn-success" href="{{url('order-history')}}">Back To Order History</a>
</div>

</div>
</div>
</div>

@endsection