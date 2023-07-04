@extends('layouts.admin')
@section('content')

<div class="card card_details1 mt-2">
   <div class="card-header py-2">
        Card Details
    </div>
<div class="card-body card-custom">
                     @if (Session::has('success'))
                     <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p><br>
                     </div>
                     @endif
                     <br>
                     <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation stor-frm-otr d-block" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                        @csrf
                        <input type="hidden" name="amount" value="10">
                        <div class='form-row row'>
                           <div class='col-xs-12 col-md-6 form-group required mb-4'>
                              <label class='control-label'>Name of Card</label> 
                              <input class='form-control' placeholder="Enter Name" size='4' type='text'>
                           </div>
                           <div class='col-xs-12 col-md-6 form-group required mb-4'>
                              <label class='control-label'>Card Number</label> 
                              <input autocomplete='off' class='form-control card-number' placeholder="Enter Card Number" size='20' type='text'>
                           </div>                           
                        </div>                        
                        <div class='form-row row'>
                           <div class='col-xs-12 col-md-4 form-group cvc required mb-4'>
                              <label class='control-label'>CVC</label> 
                              <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required mb-4'>
                              <label class='control-label'>Expiration Month</label> 
                              <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required mb-4'>
                              <label class='control-label'>Expiration Year</label> 
                              <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                           </div>
                        </div>
                      {{-- <div class='form-row row'>
                         <div class='col-md-12 error form-group hide'>
                            <div class='alert-danger alert'>Please correct the errors and try
                               again.
                            </div>
                         </div>
                      </div> --}}
                        <div class="form-row row my-3">
                           <div class="col-xs-12">
                              <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now(10)</button>
                           </div>
                        </div>
                     </form>
                  </div>

  </div>
@endsection