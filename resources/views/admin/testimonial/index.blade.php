@extends('layouts.admin')
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            @if(auth()->user()->user_type == "A")
               <a class="btn btn-success" href="{{ route("admin.testimonial.create") }}">
             @elseif(auth()->user()->user_type == "V")   
               <a class="btn btn-success" href="{{ route("vendor.testimonial.create") }}">
            @endif
                {{ trans('global.add') }} Testimonial
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
       Testimonial {{ trans('global.list') }}
    </div>

    <div class="card-body custom-tble category-table">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        
                        <th>Name</th>
                        <th>Title</th>
                        <th>Description</th>
						<th>Image</th>
                        <th>Actions </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testimonials as $key => $testimonial)
                        <tr data-entry-id="{{ $testimonial->id }}">
                            <td>{{ ucfirst($testimonial->name) ?? '' }}</td>
                            <td>{{ ucfirst($testimonial->title) ?? '' }}</td>
                            <td>{{ $testimonial->message ?? '' }}</td>
							<td><img src="{{asset('upload/images/'.$testimonial->cover_image) }}" height="50px" width="50px" />    
                            </td>
                            <td>
                                <a class="btn btn-xs btn-info" href="{{ route('admin.testimonial.edit', $testimonial->id) }}">
                                     <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                   <form action="{{ route('admin.testimonial.destroy', $testimonial->id) }}" method="POST" onsubmit="return confirm('Are you want to delete !');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                     <a class="btn btn-xs tble-delte"><input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}"></a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate-records">
                {{ $testimonials->links() }}
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
                data: { product_id: product_id, status: status, model: 'categories' },
                success: function (data){
                    $(".update-status").show(); 
                    window.setTimeout(function(){location.reload()},2000);
                }
            })
        }

        else{
            location.reload();
        }
    }

    // Update category status
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

</script>
@endsection