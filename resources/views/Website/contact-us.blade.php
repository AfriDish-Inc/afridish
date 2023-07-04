@extends('layouts.user')
@section('content')
    <?php //echo "<pre>"; print_r($itemdata);die;
    ?>
    <script>
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif
        @if (Session::has('errors'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('errors') }}");
        @endif
    </script>
    <div class="container-fluid contact-us">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul class="icons">
                        <li>
                            <div class="div-c"><img src="{{ asset('website/img/location2.svg') }}">
                                <h4>Location</h4>
                            </div>
                            <span> TORONTO, CANADA</span>
                        </li>
                        <li>
                            <div class="div-c"><img src="{{ asset('website/img/globe.svg') }}">
                                <h4>Mail us</h4>
                            </div>
                            <span>support@afridish.ca</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 c-us">
                    <form class="review-form contact-us" method="post" action="{{ url('contact-us') }}">
                        @csrf
                        <div class="wrapper">
                            <h2>Contact Us Now</h2>
                            <p>For inquiries and advertisements, please fill out the form below, we typically respond within
                                24 hours, your inquiries are very important to us.</p>
                        </div>
                        <div class="form-groups">
                            <div class="name">
                                <label>Name</label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" required>
                            </div>
                            <div class="email">
                                <label>Email</label>
                                <input type="text" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea rows="3" cols="40" name="user_query" required>{{ old('user_query') }}</textarea>
                        </div>
                        <div class="submit-cancel">
                            <button type="submit" class="sbmt">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
