@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       Order Requests
    </div>

    <div class="card-body custom-tble category-table">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Inquiry">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Dish</th>
                        <th>Message</th>
                        <th>Requested For</th>
                        <th>Received</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inquiries as $inquiry)
                        <tr data-entry-id="{{ $inquiry->id }}">
                            <td>{{ $inquiry->user->name ?? '' }}</td>
                            <td><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></td>
                            <td>{{ $inquiry->product->name ?? 'General inquiry' }}</td>
                            <td>{{ $inquiry->message }}</td>
                            <td>{{ $inquiry->requested_date ? $inquiry->requested_date->format('M j, Y') : '' }}</td>
                            <td>{{ $inquiry->created_at->format('M j, Y g:ia') }}</td>
                            <td>
                                <select class="inquiry-status" data-val="{{ $inquiry->id }}">
                                    <option value="0" @if($inquiry->status == 0) selected @endif>New</option>
                                    <option value="1" @if($inquiry->status == 1) selected @endif>Contacted</option>
                                    <option value="2" @if($inquiry->status == 2) selected @endif>Closed</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate-records">
                {{ $inquiries->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    $(".inquiry-status").change(function()
    {
        var inquiry_id = $(this).attr('data-val');
        var status = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: 'POST',
            url: '{{ route("vendor.inquiries.update-status") }}',
            data: { inquiry_id: inquiry_id, status: status },
            success: function (data){
                toastr.options = {
                    "closeButton" : true,
                    "progressBar" : true
                }
                toastr.success("Status updated");
            }
        })
    });
</script>
@endsection
