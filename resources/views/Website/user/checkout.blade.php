@extends('layouts.user')
@section('content')
<?php //echo "<pre>"; print_r($cartdata['addressdata']); die; ?>
<div class="container testimonials subscription">
    <div class="row">
        <div class="col-md-12">
          <div class="wrapper all-products">
            <h2>Checkout</h2>
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
      toastr.success("{{ session('errors') }}");
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
  <div class="row">
    <div class="col-md-3">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link " href="{{url('shoping-cart')}}"><img src="{{ asset('website/img/cart-c.svg')}}"> CART</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('billing-address')}}"><img src="{{ asset('website/img/user.svg')}}"> BILLING ADDRESS</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="{{url('checkout')}}"><img src="{{ asset('website/img/support.svg')}}"> CHECKOUT</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('order-history')}}"><img src="{{ asset('website/img/o-history.svg')}}"> ORDER HISTORY</a>
    </li>
   <!--  <li class="nav-item">
      <a class="nav-link" href="{{url('order-history')}}"><img src="{{ asset('website/img/saved.svg')}}"> SAVED ADDRESSES</a>
    </li> -->
  </ul>
</div>
  <!-- Tab panes -->
  <div class="col-md-9">
  <div class="tab-content">
    
    
    <div id="checkout" class="container tab-pane active">
      <div class="row">
      <form method="POST" id="cart_form" action="{{route('product_checkout')}}">
         @csrf
          
        <div class="col-md-7 ship-methd">
          <p class="billing-heading">Payment Method</p>
           <input type="hidden" id="stripe_id" value="{{Auth::user()->stripe_id}}">
            <input type="hidden" name="subtotal" value="{{array_sum($total)}}">
            <input type="hidden" name="tax_percent" value="20">
            <input type="hidden" name="shipping_cost" value="0">
            <input type="hidden" name="product_quantity" value="{{array_sum($productQuantity)}}">
            <input type="hidden" id="product_id" name="product_id" value="{{implode('|',$totalProduct)}}">
            <input type="hidden" name="tax" value="{{array_sum($total)*.2}}">
            <input type="hidden" name="grand_total" value="{{array_sum($total)+(array_sum($total)*.2)+0}}">
          <div class="shipping-method">
            <div class="custom-control custom-radio my-3 fw-500">
              <input type="radio" class="custom-control-input payment_method" id="cap-opt-4" name="payment_method" value="stripe">
              <label class="custom-control-label" for="cap-opt-4">
                <span class="cap-opt-1">Stripe</span>
              </label>
              <img src="{{ asset('website/img/paypal.svg')}}">
            </div>
            <div class="custom-control custom-radio my-3 fw-500 active">
              <input type="radio" checked="checked" class="custom-control-input payment_method" id="cap-opt-11" name="payment_method" value="cod" required>
              <label class="custom-control-label" for="cap-opt-11">
                <span class="cap-opt-1">Cash On Delivery</span>
              </label>
              <label class="decription-para">Your Product will be delivered at your doorsteps, hassle free.</label>
            </div>
          </div>
          <p class="billing-heading">Select Address</p>
          <div class="shipping-method">
            <div class="custom-control custom-radio my-3 fw-500 a-list">
              <div class="address-list">
              <input type="radio" class="custom-control-input" id="cap-opt-10" name="address_id" value="{{$cartdata['addressdata']->id ?? ''}}" required checked>
              <label class="custom-control-label" for="cap-opt-10">
                <span class="cap-opt-1">Billing Address</span>
              </label>
              </div>
              <span class="address-para">Name : {{$cartdata['addressdata']->first_name ?? ''}} {{$cartdata['addressdata']->last_name ?? ''}} </br> Address : {{$cartdata['addressdata']->address1 ?? ''}} </br>Address2 :  {{$cartdata['addressdata']->address2 ?? ''}}</br>Mobile no :  {{$cartdata['addressdata']->mobile_number ?? ''}}</br>City :  {{$cartdata['addressdata']->city ?? ''}}</br>
              Zipcode:  {{$cartdata['addressdata']->zip_code ?? ''}}</br> State :  {{$cartdata['addressdata']->state ?? ''}}</span>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="summary payment checkout">
            <h4>Billing Summary</h4>
            <div class="order-total">
              <p>Subtotal</p>
              <p>${{array_sum($total)}}</p>
            </div>
            <div class="order-total">
              <p>Shipping</p>
              <p>$0.00</p>
            </div>
            <div class="order-total">
              <p>Tax</p>
              <p>${{array_sum($total)*.2}}</p>
            </div>
            <div class="order-final">
              <p>Grand Total </p>
              <p>${{array_sum($total)+(array_sum($total)*.2)+0}}</p>
            </div>
            <div class="terms">
              <div class="form-group">
                <input type="checkbox" id="x" required style="width: 25px">
                <label for="x">Please check to acknowledge our <a href="#">Privacy & Terms Policy</a>
                </label>
              </div>
            </div>
            <button type="button" class="pay-now checkout_form" @if(array_sum($total) == 0 ) disabled  @else  @endif>Pay ${{array_sum($total)+(array_sum($total)*.2)+0}}</button>

          </div>
             </div>
            </form>
      </div>
    </div>
  </div>
</div>

</div>
</div>
</div>
<div class="modal fade" id="paymentCardModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header border-0">
                <div class="sub_heading text-center">
                    <h2 class="position-relative">Payment Information</h2>
                    
                </div>
                <button type="button" class="btn-close p-0 border-0" data-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('website/img/model_close.svg')}}" alt="close">
                </button>
            </div>
            <div class="modal-body">
               <div class="pay-form">
                       <form method="POST" id="card_form" action="" class="w-100">
                         @csrf
                    <div class="form-container">
                        <div class="field-container mb-3">
                            <label for="name">Name</label>
                            <input id="holder_name" name="name" maxlength="20" type="text">
                        </div>
                        <div class="field-container mb-3">
                            <label for="cardnumber">Card Number</label>
                            <input id="cardnumber" name="card_number" type="text" pattern="[0-9]*" inputmode="numeric">
                          

                            
                        </div>
                        <div class="field-container mb-3">
                            <label for="expirationdate">Expiration (mm/yy)</label>
                           <div class="exp-wrapper row">
                            <div class="col-md-6">
                                <input autocomplete="off" class="exp" id="month" maxlength="2" pattern="[0-9]*" inputmode="numerical" placeholder="MM" type="text" data-pattern-validate />
                            </div>
                            <div class="col-md-6">
                              <input autocomplete="off" class="exp" id="year" maxlength="2" pattern="[0-9]*" inputmode="numerical" placeholder="YY" type="text" data-pattern-validate />
                            </div>
                              
                            </div>
                        </div>
                        <div class="field-container mb-3">
                            <label for="securitycode">Security Code</label>
                            <input id="securitycode" name="cvc" type="text" pattern="[0-9]*" inputmode="numeric">
                        </div>
                    </div>
                    <div class="mb-3 mt-1">
                        <button class="btn main_btn text-white w-100 my-4 user_card">Confirm Information</button>
                    </div>
                    </form>
                </div>
        </div>
    </div>
</div>
 </div>
@endsection