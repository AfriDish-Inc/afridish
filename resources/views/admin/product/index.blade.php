@extends('layouts.admin')
@section('content')
<?php //echo "<pre>"; print_r($products);die; ?>
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            @if(auth()->user()->user_type == "A")
               <a class="btn btn-success" href="{{ route("admin.product.create") }}">
             @elseif(auth()->user()->user_type == "V")   
                <a class="btn btn-success" href="{{ route("vendor.product.create") }}">
            @endif
           
                {{ trans('global.add') }} Product
            </a>
        </div>
    </div>

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
       Product {{ trans('global.list') }}
    </div>
    <div class="card-body custom-tble">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                       <th>Name</th>
                       <th>Details</th>
                       <th>Description</th>
						<th>Category</th>
                        <th>Price</th>
						<th>Quantity</th>
						<th>Image</th>
                       <!--  <th>Is Feature</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
					
                        <tr data-entry-id="{{ $product->id }}">
                            <td>
                                {{ ucfirst($product->name) ?? '' }}
                            </td>
							
							 <td>
                                {{ $product->detail ?? '' }}
                            </td>
                            <td>
                                {{ $product->description ?? '' }}
                            </td>
							<td>
                                {{ $product->category[0]->category_name ?? '' }}
                            </td>
                            <td>
                                {{ $product->price ?? '' }}
                            </td>
							<td>
                                {{ $product->quantity ?? '' }}
                            </td>
							 <td>
                             <?php $images = explode('|',$product->image); ?>  
                              @foreach($images as $image)
							 <img src="{{asset('upload/images/'.$image) }}" height="50px" width="80px">
                              @endforeach
                                
                            </td>
                           <!--  <td>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @if($product->is_feature == 1)
                                        <label class="btn btn-secondary feature-btn-active active" data-val="{{ $product->id }}">
                                            <input type="radio" name="featured" id="option1" autocomplete="off" checked> On
                                        </label>
                                        <label class="btn btn-secondary feature-btn-inactive" data-val="{{ $product->id }}">
                                            <input type="radio" name="featured" id="option2" autocomplete="off"> Off
                                        </label>
                                    @else
                                        <label class="btn btn-secondary feature-btn-active" data-val="{{ $product->id }}">
                                            <input type="radio" name="featured" id="option1" autocomplete="off" checked> On
                                        </label>
                                        <label class="btn btn-secondary feature-btn-inactive active" data-val="{{ $product->id }}">
                                            <input type="radio" name="featured" id="option2" autocomplete="off"> Off
                                        </label>
                                    @endif
                                </div>
                            </td> -->
                            <!-- <td>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @if($product->is_active == 1)
                                        <label class="btn btn-secondary status-btn-active active" data-val="{{ $product->id }}">
                                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Active
                                        </label>
                                        <label class="btn btn-secondary status-btn-inactive" data-val="{{ $product->id }}">
                                            <input type="radio" name="options" id="option2" autocomplete="off"> Inactive
                                        </label>
                                    @else
                                        <label class="btn btn-secondary status-btn-active" data-val="{{ $product->id }}">
                                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Active
                                        </label>
                                        <label class="btn btn-secondary status-btn-inactive active" data-val="{{ $product->id }}">
                                            <input type="radio" name="options" id="option2" autocomplete="off"> Inactive
                                        </label>
                                    @endif
                                </div>
                            </td> -->
                            <td>
            
                                @if(auth()->user()->user_type == "A")
                                  <a class="btn btn-xs btn-info" href="{{ route('admin.product.edit', $product->id) }}">
                                 @elseif(auth()->user()->user_type == "V")   
                                   <a class="btn btn-xs btn-info" href="{{ route('vendor.product.edit', $product->id) }}">
                                @endif
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>

                                @if(auth()->user()->user_type == "A")
                                  <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                 @elseif(auth()->user()->user_type == "V")   
                                   <form action="{{ route('vendor.product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                @endif
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <a class="btn btn-xs tble-delte"><input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </a>
                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="paginate-records">
                {{ $products->links() }}
            </div>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('users_manage')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.mass_destroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: [ ] , "paging": false ,
  'columnDefs': [
      {
         'targets': 0,
         'checkboxes': {
              
         }
     }
 ] , "info": false })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

    function updateProductStatus(product_id,status)
    {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        
        if (confirm('{{ trans('global.areYouSure') }}')) 
        {
            $.ajax({
                method: 'POST',
                url: 'updateStatus',
                data: { product_id: product_id, is_feature: status, model: 'products' },
                success: function (data){
                    if(data.hasOwnProperty('inStore'))
                    {
                        $(".inStore-status").show(); 

                    }

                    else
                    {
                        toastr.options ={
                              "closeButton" : true,
                              "progressBar" : true
                        }

                        toastr.success("Status updated successfully"); 
                    }

                    window.setTimeout(function(){location.reload()},2000);
                }
            })
        }

        else{
            location.reload();
        }
    }

    // Update product status
    $(".status-btn-active").click(function()
    {
        var product_id = $(this).attr('data-val');
        var status = 1;

        updateProductStatus(product_id,status);
    });

    $(".status-btn-inactive").click(function()
    {
        var product_id = $(this).attr('data-val');
        var status = 0;

        updateProductStatus(product_id,status);
    });


    function updateProductFeatures(product_id,status)
    {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        
        if (confirm('{{ trans('global.areYouSure') }}')) 
        {
            $.ajax({
                method: 'POST',
                url: 'updateFeatures',
                data: { product_id: product_id, status: status, model: 'products' },
                success: function (data){
                    if(data.hasOwnProperty('inStore'))
                    {
                        $(".inStore-status").show(); 

                    }

                    else
                    {
                        toastr.options ={
                              "closeButton" : true,
                              "progressBar" : true
                        }

                        toastr.success("Is feature updated successfully"); 
                    }

                    window.setTimeout(function(){location.reload()},2000);
                }
            })
        }

        else{
            location.reload();
        }
    }

    // Update product features
    $(".feature-btn-active").click(function()
    {
        var product_id = $(this).attr('data-val');
        var status = 1;

        updateProductFeatures(product_id,status);
    });


    $(".feature-btn-inactive").click(function()
    {
        var product_id = $(this).attr('data-val');
        var status = 0;

        updateProductFeatures(product_id,status);
    });

</script>
@endsection