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
                <th>{{ __('Action') }}</th>
            </tr>
            <tr class="table-filter">
                <th><input type="search" class="form-control" name="fName" value="{{ $filter->fName }}"></th>
                <th><input type="search" class="form-control" name="fCode" value="{{ $filter->fCode }}"></th>
                <th><input type="search" class="form-control" name="fPhone" value="{{ $filter->fPhone }}"></th>
                <th>&nbsp;</th>
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
                        {data: 'currency', name: 'currency'},
                        {}
                    ],
                    columnDefs: [
                        {
                            targets: -1,
                            data: null,
                            defaultContent: '<div class="btn-group">' +
                                '<a href="#" class="btn btn-sm btn-edit btn-light js-tooltip-enabled" data-toggle="tooltip" title="Edit user"><i class="fa fa-fw fa-pencil-alt"></i></a>' +
                                '<a href="#" class="btn btn-sm btn-delete btn-light js-tooltip-enabled" data-toggle="tooltip" title="Remove store"><i class="fa fa-fw fa-times"></i></a>' +
                                '</div>'
                        }
                    ],
                }
            );

            let table = jQuery('#table').DataTable();

            jQuery(document).on( 'click', '.btn-edit', function () {
                let id = table.row( jQuery(this).parents('tr')[0] ).data().id;
                window.location.href = '{!! route('stores.form', ['id' => null]) !!}/' + id;
            } );

            jQuery(document).on( 'click', '.btn-delete', function () {

                if( !confirm('Remove store?') ){
                    return;
                }

                let id = table.row( jQuery(this).parents('tr')[0] ).data().id;
                window.location.href = '{!! route('stores.index') !!}/' + id + '/delete';
            } );
        });
    </script>
@endsection
