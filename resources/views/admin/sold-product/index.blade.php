@extends('layouts.admin')
@section('content') 
<?php //echo "<pre>"; print_r($data); die; ?>   
<div class="card">
    <div class="card-header">
     Sold Products
    </div>
    <div class="card-body custom-tble">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                       <th>Order Id</th>
                       <th>Product Name</th>
                       <th>Amount</th>
                       <th>Qty</th>
                       <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $order)
                        <tr data-entry-id="{{ $order->id }}">   
                            <td>
                                {{ $order->order_id ?? '' }}
                            </td> 
                            <td>
                                {{\App\Models\Product::where('id',$order->product_id)->first()->name  ?? '' }}
                            </td>
                            <td>
                                {{ $order->price ?? '' }}
                            </td>
                            <td>
                                {{ $order->order_quantity ?? '' }}
                            </td>
                            @switch($order->status)
                                @case(0)
                                    <td>Pending</td>
                                    @break
                                @case(1)
                                    <td>Processed</td>
                                    @break
                                @case(2)
                                    <td>Deliverd</td>
                                    @break    
                            @endswitch
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="paginate-records">
                <!-- {{ $data->links() }} -->
            </div>
        </div>
    </div>
</div>
@endsection