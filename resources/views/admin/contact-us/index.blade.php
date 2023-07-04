@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
       Contact us {{ trans('global.list') }}
    </div>

    <div class="card-body custom-tble category-table">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contactus as $key => $contact)
                        <tr data-entry-id="{{ $contact->id }}">
                            <td> {{ ucfirst($contact->full_name) ?? '' }}</td>
                            <td> {{ ucfirst($contact->email) ?? '' }}</td>
                            <td> {{ ucfirst($contact->user_query) ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate-records">
                {{ $contactus->links() }}
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

function updateProductStatus(id,status)
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
                data: { id: id, status: status, model: 'tags' },
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