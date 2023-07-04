@extends('layouts.app')
@section('content')

<div class="row justify-content-center">


    <div class="col-md-6">
        <!-- LOADER -->
        <div class="loader-bg" style="display: none;">
            <div class="text-center loader">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        
        <!---------------------->
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <form method="POST" action="{{ url('api/password/reset') }}" class="resetform">
            {{ csrf_field() }}
            <h1>
                <div class="login-logo">
                    <img src="{{ asset('images/logo.png') }}" style="height: 55px">
                </div>
            </h1>
            @if($errors->has('token'))
            <em class="invalid-feedback">
                {{ $errors->first('token') }}
            </em>
            @endif
            <p class="text-muted"></p>
            <div>
                <input name="token" value="{{ $passwordReset->token ?? '' }}" type="hidden">
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" required placeholder="Email">

                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" required placeholder="Password">
                    @if($errors->has('password'))
                    <em class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </em>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Password confirmation">
                    @if($errors->has('password_confirmation'))
                    <em class="invalid-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </em>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <button type="submit" class="btn btn-primary btn-block btn-flat btn-submit">
                        Reset Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php $status = 0; ?> 
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".resetform").submit(function(e) {
        // SHOW LOADER
        $(".loader-body").css({"display":"flex"});

        e.preventDefault();
        var password_confirmation = $("input[name=password_confirmation]").val();
        var password = $("input[name=password]").val();
        var email = $("input[name=email]").val();
        var token = $("input[name=token]").val();

        $.ajax({
            type: 'POST',
            url: "{{ URL::to('/api/password/reset') }}",
            data: {
                password_confirmation: password_confirmation,
                password: password,
                email: email,
                token: token
            },
            success: function(data) {
                // HIDE loader-bg
                $(".loader-body").hide();

                //SHOW MODAL
                $('#exampleModalCenter').modal('show');

                if (data.hasOwnProperty('message')) {
                    swal.fire({
                        animation: true,
                        icon: 'success',
                        title: data.message,
                        closeOnClickOutside: false,
                        allowOutsideClick: false,
                        backdrop: `rgba(0,0,123,0.4) left top no-repeat`
                    }).then(function() {
                        window.location.href = "{{ URL::to('/') }}";
                    });
                }

                if (data.hasOwnProperty('inavlid')) {
                    swal.fire({
                        animation: true,
                        icon: 'error',
                        title: data.inavlid,
                        closeOnClickOutside: false,
                        allowOutsideClick: false,
                        backdrop: `rgba(0,0,123,0.4) left top no-repeat`
                    });
                }

                if (data.hasOwnProperty('errors')) {
                    console.log(data.errors);
                    var emailError = '';
                    var cpasswordError = '';
                    var passwordError = '';

                    if (data.errors.hasOwnProperty('email')) {
                        emailError = data.errors.email[0];
                    }

                    if (data.errors.hasOwnProperty('password_confirmation')) {
                        cpasswordError = data.errors.password_confirmation[0];
                    }

                    if (data.errors.hasOwnProperty('password')) {
                        passwordError = data.errors.password[0];
                    }

                    swal.fire({
                        animation: true,
                        icon: 'error',
                        title: emailError + cpasswordError + passwordError,
                        closeOnClickOutside: false,
                        allowOutsideClick: false,
                        backdrop: `rgba(0,0,123,0.4) left top no-repeat`
                    });
                }
            }
        });
    });




    var status = '{{$status}}';
    var message = '{{$message}}';


    if (status == 0) {
        swal.fire({
            animation: true,
            icon: 'error',
            timer: 5000,
            title: 'This password reset token is invalid.',
            closeOnClickOutside: false,
            allowOutsideClick: false,
            backdrop: `rgba(0,0,123,0.4) left top no-repeat`,
        }).then(function() {
            window.location.href = "{{ URL::to('/') }}";
        });
    }
</script>
@endsection