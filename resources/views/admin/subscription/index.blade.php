@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-body card-custom pt-4 mt-2">
        <form action="{{ url('stripe') }}" >
            @csrf
         <input type="hidden" name="amount" value="10">
        <div class="stor-frm-otr align-items-center mb-3">
            <div class="form_head">
               <h1 class="mb-0">Monthly Subscription ($10) Buy membership to add unlimited listing</h1>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" @if($validity > 0) disabled @else  @endif value="Buy($10)">
            </div>
        </form>
    </div>  
</div>
@if($subscription)
<div class="card card-custom-section">
    <div class="card-body card-custom">
        <div class="stor-frm-otr">
            <div class="form-group">
                <label for="title"><h3>Plan Start Date</h3><h2>{{$subscription->start_at ?? ""}}</h2></label>
            </div>
            <div class="form-group">
                <label for="title"><h3>Plan End Date</h3><h2>{{$subscription->expire_at ?? ""}}</h2></label>
            </div>

       </div>
  </div>
</div>
@else
<div class="card">
    <div class="card-body card-custom">
        <div class="stor-frm-otr">
            <div class="form-group">
                <label for="title"><h3>No plan available please subscribe</h3></label>
            </div>
       </div>
  </div>
</div>
@endif
@if($account)
<div class="card-body add_bank">
    <a href="{{url('vendor/add-account')}}" class="btn btn-success">Update bank account</a>
</div>
@else
<div class="card-body add_bank">
    <a href="{{url('vendor/add-account')}}" class="btn btn-success">Add bank account</a>
</div>
@endif

@if($account)
<div class="card user_details1">
    <div class="card-body card-custom">
        <div class="stor-frm-otr">
            <div class="row">
                <div class="col-md-4 my-3">
                    <div class="form-group">
                        <label for="title"><h6>Bank Name</h6><h3>{{$account->account_bank}}</h3></label>
                    </div>
                </div>
                <div class="col-md-4 my-3">
                    <div class="form-group">
                        <label for="title"><h6>Account No</h6><h3>{{$account->account_number}}</h3></label>
                    </div>
                </div>
                <div class="col-md-4 my-3">
                     <div class="form-group">
                        <label for="title"><h6>Bank Code</h6><h3>{{$account->bank_code}}</h3></label>
                    </div>
                </div>
                <div class="col-md-4 my-3">
                     <div class="form-group">
                        <label for="title"><h6>Currency</h6><h3>{{$account->currency}}</h3></label>
                    </div>
                </div>
                <div class="col-md-4 my-3">
                    <div class="form-group">
                        <label for="title"><h6>Beneficiary Name</h6><h3>{{$account->beneficiary_name}}</h3></label>
                    </div>
                </div> 
       </div>
  </div>
</div>
</div>
@else
<div class="card">
    <div class="card-body card-custom">
        <div class="stor-frm-otr">
            <div class="form-group">
                <label for="title"><h3>No Bank Account</h3></label>
            </div>
       </div>
  </div>
</div>
@endif
@endsection
@section('scripts')
@parent
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
$(function() {
  var $form = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form = $(".require-validation"),
    inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
    $inputs = $form.find('.required').find(inputSelector),
    $errorMessage = $form.find('div.error'),
    valid = true;
    $errorMessage.addClass('hide');
    $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
        var $input = $(el);
        if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
        }
    });
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
          number: $('.card-number').val(),
          cvc: $('.card-cvc').val(),
          exp_month: $('.card-expiry-month').val(),
          exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  });

  function stripeResponseHandler(status, response) {
    alert(status);
    alert(response);
      if (response.error) {
          $('.error')
              .removeClass('hide')
              .find('.alert')
              .text(response.error.message);
      } else {
          /* token contains id, last4, and card type */
          var token = response['id'];

          $form.find('input[type=text]').empty();
          $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
          $form.get(0).submit();
      }
  }
});
</script>

@endsection