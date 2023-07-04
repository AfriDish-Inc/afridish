@extends('layouts.admin')
@section('content')
<div class="dashboard-wrapper">
    <div class="number-boxes-otr">
        <div class="content">
            <div class="row">
                <div class="dashboard-hdng">
                    Dashboard
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                     @if(Auth::user()->user_type == "V")
                       <a href="{{url('vendor/product')}}">
                    @else
                       <a href="{{url('admin/product')}}">
                    @endif
                    <div class="dashboard-body">
                        <div class="nuumbr-otr">
                            <div class="numbr-inr w-100">
                                <div class="num-txt">
                                    <p>Total no. of products <span> {{ $totalProducts }} </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-4 mb-2">
                    @if(Auth::user()->user_type == 'V')
                    <div class="dashboard-body">
                        <div class="nuumbr-otr">
                            <div class="numbr-inr w-100">
                                <div class="num-txt">
                                    <p>Plan Validity <span> {{ $validity }} </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
