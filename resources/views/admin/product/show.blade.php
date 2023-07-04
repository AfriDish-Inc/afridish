@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} Store
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $store->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Name
                        </th>
                        <td>
                            {{ $store->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Detail
                        </th>
                        <td>
                            {{ $store->detail }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Address
                        </th>
                        <td>
                             {{ $store->address }}
                        </td>
                    </tr>
					 <tr>
                        <th>
                           Phone Number
                        </th>
                        <td>
                             {{ $store->phone_number }}
                        </td>
                    </tr>
					  <tr>
                        <th>
                            Lat
                        </th>
                        <td>
                             {{ $store->lat }}
                        </td>
                    </tr>
					  <tr>
                        <th>
                           Lng
                        </th>
                        <td>
                             {{ $store->lng }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>


    </div>
</div>
@endsection