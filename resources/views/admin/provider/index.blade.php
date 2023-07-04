@extends('layouts.admin')
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.provider.create") }}">
                {{ trans('global.add') }} Vendor
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
       Vendor {{ trans('global.list') }}
    </div>

    <div class="card-body custom-tble category-table">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
						<th>Profile Picture</th>
                       <!--  <th>Status</th> -->
                        <th>Is Featured</th>
                        <th>Is Recommended</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($providers as $key => $provider)
                        <tr data-entry-id="{{ $provider->id }}">
                            
                            <td>{{ ucfirst($provider->name) ?? '' }}</td>
                            <td>{{ $provider->email ?? '' }}</td>
                            <td>{{ $provider->mobile_number ?? '' }}</td>
							<td>
    							<img src="{{asset('upload/images/'.$provider->profile_picture) }}" height="50px" width="50px" />    
                            </td>
                            <td>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @if($provider->is_feature == 1)
                                        <label class="btn btn-secondary feature-btn-active active" data-val="{{ $provider->id }}">
                                            <input type="radio" name="featured"  autocomplete="off" checked> On
                                        </label>
                                        <label class="btn btn-secondary feature-btn-inactive" data-val="{{ $provider->id }}">
                                            <input type="radio" name="featured"  autocomplete="off"> Off
                                        </label>
                                    @else
                                        <label class="btn btn-secondary feature-btn-active" data-val="{{ $provider->id }}">
                                            <input type="radio" name="featured"  autocomplete="off" checked> On
                                        </label>
                                        <label class="btn btn-secondary feature-btn-inactive active" data-val="{{ $provider->id }}">
                                            <input type="radio" name="featured"  autocomplete="off"> Off
                                        </label>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @if($provider->is_recommended == 1)
                                        <label class="btn btn-secondary recom-btn-active active" data-val="{{ $provider->id }}">
                                            <input type="radio" name="recommended"  autocomplete="off" checked> On
                                        </label>
                                        <label class="btn btn-secondary recom-btn-inactive" data-val="{{ $provider->id }}">
                                            <input type="radio" name="recommended" autocomplete="off"> Off
                                        </label>
                                    @else
                                        <label class="btn btn-secondary recom-btn-active" data-val="{{ $provider->id }}">
                                            <input type="radio" name="recommended" autocomplete="off" checked> On
                                        </label>
                                        <label class="btn btn-secondary recom-btn-inactive active" data-val="{{ $provider->id }}">
                                            <input type="radio" name="recommended" autocomplete="off"> Off
                                        </label>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-info" href="{{ route('admin.provider.edit', $provider->id) }}">
                                    <!--{{ trans('global.edit') }}-->
                                     <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>

                                <form action="{{ route('admin.provider.destroy', $provider->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
									<input type="hidden" name="id" value="{{$provider->id ?? '' }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                     <a class="btn btn-xs tble-delte"><input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}"></a>
                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate-records">
                {{ $providers->links() }}
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

function updateUserFeatures(id,status)
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
                data: { id: id, status: status, model: 'users' },
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
                        //$(".update").show(); 
                    }

                    window.setTimeout(function(){location.reload()},2000);
                }
            })
        }

        else{
            location.reload();
        }
    }

    // Update vendor features
    $(".feature-btn-active").click(function()
    {
        var user_id = $(this).attr('data-val');
        var status = 1;

        updateUserFeatures(user_id,status);
    });


    $(".feature-btn-inactive").click(function()
    {
        var user_id = $(this).attr('data-val');
        var status = 0;

        updateUserFeatures(user_id,status);
    });



function updateUserRecommended(id,status){
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        
        if (confirm('{{ trans('global.areYouSure') }}')) 
        {
            $.ajax({
                method: 'POST',
                url: 'updateRecommended',
                data: { id: id, status: status, model: 'users' },
                success: function (data){
                        toastr.options ={
                              "closeButton" : true,
                              "progressBar" : true
                        }
                        toastr.success("Is Recommended updated successfully");
                        //$(".update").show(); 
                    window.setTimeout(function(){location.reload()},2000);
                }
            })
        }else{
            location.reload();
        }
    }


    $(".recom-btn-active").click(function()
    {
        var user_id = $(this).attr('data-val');
        var status = 1;

        updateUserRecommended(user_id,status);
    });


    $(".recom-btn-inactive").click(function()
    {
        var user_id = $(this).attr('data-val');
        var status = 0;

        updateUserRecommended(user_id,status);
    });

</script>
@endsection