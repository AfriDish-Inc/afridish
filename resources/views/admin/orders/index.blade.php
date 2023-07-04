@extends('layouts.admin')
@section('content')    
    <!-- @if ($message = Session::get('message'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif -->
    <script>
      @if(Session::get('message'))
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true
      }
          toastr.success("{{ session('message') }}");
      @endif

      @if(Session::get('success'))
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true
      }
          toastr.success("{{ session('success') }}");
      @endif
    </script>
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Opps!</strong> Something went wrong<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
   @endif
<div class="card">
    <div class="card-header">
       Order {{ trans('global.list') }}
    </div>
    <div class="card-body custom-tble">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                       <th>Customer Name</th>
                       <th>Customer Email</th>
                       <th>Customer Mobile</th>
                       <th>Order Type</th>
                       <th>Order Date</th>
                       <th>Amount</th>
                       <th>Order Quantity</th>
					   <th>Status</th>
                       <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $key => $order)
                        <tr data-entry-id="{{ $order->id }}">
                            <td>
                                {{ App\Models\User::where('id',$order->user_id)->first()->name ?? "" }}
                            </td>

                            <td>
                                {{ App\Models\User::where('id',$order->user_id)->first()->email ?? "" }}
                            </td>

                            <td>
                                {{ App\Models\User::where('id',$order->user_id)->first()->mobile_number ?? "" }}
                            </td>
							
							 <td>
                                {{ $order->order_type ?? '' }}
                            </td>
                            <td>
                                {{ $order->order_date ?? '' }}
                            </td>
							<td>
                                {{ $order->amount ?? '' }}
                            </td>
                            <td>
                                {{ $order->quantity ?? '' }}
                            </td>
                            @switch($order->order_status)
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
                            
                            <td>
            
                            @if(auth()->user()->user_type == "A")
                              
                             
                             @elseif(auth()->user()->user_type == "V")   
                               <a class="btn btn-xs btn-info" href="{{url('vendor/update-order?id=')}}{{$order->id}}">
                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                               
                            @endif
                                

                            @if(auth()->user()->user_type == "A")
                              <a class="btn btn-xs btn-info" href="{{url('admin/show-order?id=')}}{{$order->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                             
                             @elseif(auth()->user()->user_type == "V")   
                               <a class="btn btn-xs btn-info" href="{{url('vendor/show-order?id=')}}{{$order->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            @endif

                             
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="paginate-records">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection