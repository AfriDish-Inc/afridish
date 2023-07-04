@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
       Users {{ trans('global.list') }}
    </div>

    <div class="card-body custom-tble category-table">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr data-entry-id="{{ $user->id }}">
                            <td>{{ ucfirst($user->name) ?? '' }}</td>
                            <td>{{ $user->email ?? '' }}</td>
                            <td>{{ $user->mobile_number ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate-records">
                {{ $users->links() }}
            </div>
        </div>


    </div>
</div>
@endsection