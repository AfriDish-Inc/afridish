@extends('layouts.admin')
@section('content')

<div class="alert alert-success update-status" style="display: none;">
    <p> Vendor status updated successfully. </p>
</div>

<div class="card">
    <div class="card-header">
       Vendor Accounts {{ trans('global.list') }}
    </div>

    <div class="card-body custom-tble category-table">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Vendor">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $key => $vendor)
                        <tr data-entry-id="{{ $vendor->id }}">
                            <td>{{ ucfirst($vendor->name) ?? '' }}</td>
                            <td>{{ $vendor->email ?? '' }}</td>
                            <td>
                                @if($vendor->user_type == 'CH') Chef
                                @elseif($vendor->user_type == 'R') Restaurant
                                @else Vendor
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @if($vendor->is_active == 1)
                                        <label class="btn btn-secondary status-btn-active active" data-val="{{ $vendor->id }}">
                                            <input type="radio" name="options-{{ $vendor->id }}" autocomplete="off" checked> Active
                                        </label>
                                        <label class="btn btn-secondary status-btn-inactive" data-val="{{ $vendor->id }}">
                                            <input type="radio" name="options-{{ $vendor->id }}" autocomplete="off"> Suspend
                                        </label>
                                    @else
                                        <label class="btn btn-secondary status-btn-active" data-val="{{ $vendor->id }}">
                                            <input type="radio" name="options-{{ $vendor->id }}" autocomplete="off"> Approve
                                        </label>
                                        <label class="btn btn-secondary status-btn-inactive active" data-val="{{ $vendor->id }}">
                                            <input type="radio" name="options-{{ $vendor->id }}" autocomplete="off" checked> Pending
                                        </label>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate-records">
                {{ $vendors->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    $(".status-btn-active").click(function()
    {
        var vendor_id = $(this).attr('data-val');
        updateVendorStatus(vendor_id, 1);
    });

    $(".status-btn-inactive").click(function()
    {
        var vendor_id = $(this).attr('data-val');
        updateVendorStatus(vendor_id, 0);
    });

    function updateVendorStatus(vendor_id, status)
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
                url: '{{ route("admin.updateStatus") }}',
                data: { product_id: vendor_id, status: status, model: 'vendors' },
                success: function (data){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.success("Status updated successfully");
                    window.setTimeout(function(){location.reload()},1000);
                }
            })
        }
    }
</script>
@endsection
