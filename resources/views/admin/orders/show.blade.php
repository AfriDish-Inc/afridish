@extends('layouts.admin')
@section('content')   
<?php //echo "<pre>"; print_r($order_details);die; ?> 
<div class="card">
    <div class="card-header">
     Order Products
    </div>
    <div class="card-body custom-tble">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                       <th>Product Name</th>
                       <th>Address</th>
                       <th>Amount</th>
                       <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order_details as $key => $order)
                        <tr data-entry-id="{{ $order->id }}">    
                             <td>
                                {{ $order->product_name ?? '' }}
                            </td>
                            <td>{{$order->address->address1}},{{$order->address->address2}},{{$order->address->city}},{{$order->address->zip_code}},{{$order->address->state}},{{$order->address->mobile_number}}</td>
                            <td>
                                {{ $order->price ?? '' }}
                            </td>
                            <td>
                                {{ $order->order_quantity ?? '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="paginate-records">
                {{ $order_details->links() }}
            </div>
        </div>
    </div>
</div>
@endsection