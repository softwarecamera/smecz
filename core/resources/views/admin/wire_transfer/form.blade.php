@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post">
                @csrf
                <x-viser-form-data :form="@$form" title="Wire Transfer Form" />
                
                @can('admin.wire.transfer.form.save')
                    <button type="submit" class="btn btn--primary w-100 h-45 mt-3">@lang('Submit')</button>
                @endcan
            </form>
        </div>
    </div>
    <x-form-generator />
@endsection
