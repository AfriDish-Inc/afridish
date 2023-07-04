@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Add Account
    </div>

    <div class="card-body card-custom">
        <form action="{{url('vendor/add-account')}}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="stor-frm-otr">
            <div class="form-group ">
                <label for="account_bank">Bank Name *</label>
                <input type="text" id="account_bank" name="account_bank" class="form-control" value="{{ old('account_bank', isset($account) ? $account->account_bank : '') }}" required>
                @if($errors->has('account_bank'))
                    <em class="invalid-feedback">
                        {{ $errors->first('account_bank') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group ">
                <label for="bank_code">Bank Code *</label>
                <input type="text" id="bank_code" name="bank_code" class="form-control" value="{{ old('bank_code', isset($account) ? $account->bank_code : '') }}" required>
                @if($errors->has('bank_code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('bank_code') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group ">
                <label for="account_number">Account Number *</label>
                <input type="text" id="account_number" name="account_number" class="form-control" value="{{ old('account_number', isset($account) ? $account->account_number : '') }}" required>
                @if($errors->has('account_number'))
                    <em class="invalid-feedback">
                        {{ $errors->first('account_number') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group ">
                <label for="currency">Transit Number*</label>
                <input type="text" id="currency" name="currency" class="form-control" value="{{ old('currency', isset($account) ? $account->currency : '') }}" required>
                @if($errors->has('currency'))
                    <em class="invalid-feedback">
                        {{ $errors->first('currency') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group ">
                <label for="beneficiary_name">Beneficiary Name *</label>
                <input type="text" id="beneficiary_name" name="beneficiary_name" class="form-control" value="{{ old('beneficiary_name', isset($account) ? $account->beneficiary_name : '') }}" required>
                @if($errors->has('beneficiary_name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('beneficiary_name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection