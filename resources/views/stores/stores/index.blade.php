@extends('layouts.backend')

@section('content')

    @include('layouts.backendPageHero', [
    	'title' => 'Stores',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add store',
                'url' => route('stores.form', 0)
            ]
    	]
    ])

    <!-- Page Content -->
    <div class="content content-full">
        <table id="table" class="table table-bordered table-hover table-vcenter js-dataTable">
            <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('External ID') }}</th>
                <th>{{ __('Phone') }}</th>
                <th>{{ __('Store group') }}</th>
                <th>{{ __('Currency') }}</th>
            </tr>
            <tr class="table-filter">
                <th><input type="search" class="form-control" name="fName" value="{{ $filter->fName }}"></th>
                <th><input type="search" class="form-control" name="fCode" value="{{ $filter->fCode }}"></th>
                <th><input type="search" class="form-control" name="fPhone" value="{{ $filter->fPhone }}"></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
        </table>
    </div>
    <!-- END Page Content -->
@endsection

@section('css_after')
    @include('helpers.datatables.includeCSS')
@endsection

@section('js_after')
    @include('helpers.datatables.includeJS')
    <script>
        jQuery(function () {
            dtAdapter.init(
                jQuery('#table'),
                '{!! route('stores.filter') !!}',
                {
                    serverSide: true,
                    ajax: '{!! route('stores.data') !!}',
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'code', name: 'code'},
                        {data: 'phone', name: 'phone'},
                        {data: 'group', name: 'group'},
                        {data: 'currency', name: 'currency'}
                    ]
                }
            );
        });
    </script>
@endsection
