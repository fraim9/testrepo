@extends('layouts.backend')

@section('content')

    @include('layouts.backendPageHero', [
    	'title' => 'Clients',
    	'btns' => [
    		[
                'class' => 'btn btn-primary',
                'caption' => 'Add client',
                'url' => route('clients.form', 0)
            ]
    	]
    ])

    <!-- Page Content -->
    <div class="content content-full">
        <table id="clientsTable" class="table table-bordered table-hover table-vcenter js-dataTable">
            <thead>
            <tr>
                <th data-class-name="text-center">{{ __('ID') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('E-mail') }}</th>
                <th>{{ __('Phone') }}</th>
                <th>{{ __('Birthday') }}</th>
                <th>{{ __('Country') }}</th>
                <th>{{ __('City') }}</th>
                <th class="text-center text-small">{{ __('Phone Opt-In') }}</th>
                <th class="text-center text-small">{{ __('Email Opt-In') }}</th>
                <th class="text-center text-small">{{ __('Msg Opt-In') }}</th>
                <th class="text-center text-small">{{ __('Postal Opt-In') }}</th>
                <th data-class-name="text-small text-center">{{ __('Consent signed') }}</th>
                <th class="text-center text-small">{{ __('Consent File') }}</th>
                <th class="text-center">Mini</th>
                <th class="text-center">AML</th>
                <th class="text-center">Responsible</th>
                <th class="text-center">Store</th>
            </tr>
            <tr class="table-filter">
                <th><input type="search" class="form-control" name="fId" value="{{ $filter->fId }}"></th>
                <th><input type="search" class="form-control" name="fName" value="{{ $filter->fName }}"></th>
                <th><input type="search" class="form-control" name="fEmail" value="{{ $filter->fEmail }}"></th>
                <th><input type="search" class="form-control" name="fPhone" value="{{ $filter->fPhone }}"></th>
                <th></th>
                <th>
                    <select class="js-select2 form-control" name="fCountry" style="width: 100%;"
                            data-placeholder="{{ __('-- all --') }}">
                        <option></option>
                        <option value="0">{{ __('-- all --') }}</option>
                        @if ($countries)
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ ($country->id == $filter->fCountry) ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </th>
                <th><input type="search" class="form-control" name="fCity" value="{{ $filter->fCity }}"></th>
                <th>
                    <select class="form-control form-control-sm" name="fVoiceOptIn">
                        <option value="">{{ __('-- all --') }}</option>
                        <option value="1" {{ (1 == $filter->fVoiceOptIn) ? 'selected' : '' }}>{{ __('selected') }}
                        </option>
                        <option value="2" {{ (2 == $filter->fVoiceOptIn) ? 'selected' : '' }}>{{ __('not selected') }}
                        </option>
                    </select>
                </th>
                <th>
                    <select class="form-control form-control-sm" name="fEmailOptIn">
                        <option value="">{{ __('-- all --') }}</option>
                        <option value="1" {{ (1 == $filter->fEmailOptIn) ? 'selected' : '' }}>{{ __('selected') }}
                        </option>
                        <option value="2" {{ (2 == $filter->fEmailOptIn) ? 'selected' : '' }}>{{ __('not selected') }}
                        </option>
                    </select>
                </th>
                <th>
                    <select class="form-control form-control-sm" name="fMsgOptIn">
                        <option value="">{{ __('-- all --') }}</option>
                        <option value="1" {{ (1 == $filter->fMsgOptIn) ? 'selected' : '' }}>{{ __('selected') }}
                        </option>
                        <option value="2" {{ (2 == $filter->fMsgOptIn) ? 'selected' : '' }}>{{ __('not selected') }}
                        </option>
                    </select>
                </th>
                <th>
                    <select class="form-control form-control-sm" name="fPostalOptIn">
                        <option value="">{{ __('-- all --') }}</option>
                        <option value="1" {{ (1 == $filter->fPostalOptIn) ? 'selected' : '' }}>{{ __('selected') }}
                        </option>
                        <option value="2" {{ (2 == $filter->fPostalOptIn) ? 'selected' : '' }}>{{ __('not selected')
                            }}
                        </option>
                    </select>
                </th>
                <th>
                    <select class="form-control form-control-sm" name="fConsentSigned">
                        <option value="">{{ __('-- all --') }}</option>
                        <option value="1" {{ (1 == $filter->fConsentSigned) ? 'selected' : '' }}>{{ __('selected') }}
                        </option>
                        <option value="2" {{ (2 == $filter->fConsentSigned) ? 'selected' : '' }}>{{ __('not selected')
                            }}
                        </option>
                    </select>
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th>
                    <select class="js-select2 form-control" name="fResponsible" style="width: 100%;"
                            data-placeholder="{{ __('-- all --') }}">
                        <option></option>
                        <option value="0">{{ __('-- all --') }}</option>
                        @if ($employees)
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ ($employee->id == $filter->fResponsible) ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </th>
                <th>
                    <select class="js-select2 form-control" name="fStore" style="width: 100%;"
                            data-placeholder="{{ __('-- all --') }}">
                        <option></option>
                        <option value="0">{{ __('-- all --') }}</option>
                        @if ($stores)
                            @foreach ($stores as $store)
                                <option value="{{ $store->id }}" {{ ($store->id == $filter->fStore) ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </th>
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
                jQuery('#clientsTable'),
                '{!! route('clients.filter') !!}',
                {
                    serverSide: true,
                    ajax: '{!! route('clients.data') !!}',
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'phone', name: 'phone'},
                        {data: 'birthday', name: 'birthday'},
                        {data: 'country', name: 'country'},
                        {data: 'city', name: 'city'},
                        {data: 'voice_opt_in', name: 'voice_opt_in'},
                        {data: 'email_opt_in', name: 'email_opt_in'},
                        {data: 'msg_opt_in', name: 'msg_opt_in'},
                        {data: 'postal_opt_in', name: 'postal_opt_in'},
                        {data: 'consent_signed', name: 'consent_signed'},
                        {data: 'consent_file_id', name: 'consent_file_id'},
                        {data: 'mini', name: 'mini'},
                        {data: 'aml', name: 'aml'},
                        {data: 'responsible', name: 'responsible'},
                        {data: 'store', name: 'store'},
                    ],
                    columnDefs: [
                        {"width": "40px", "sortable": false, targets: [7, 8, 9, 10, 11, 12, 13, 14]},
                        {"width": "40px", targets: [0]},
                        {"sortable": false, targets: [5, 15, 16]},
                        {"visible": false, targets: [4, 5, 6, 11, 15, 16]},
                    ],
                }
            );
        });
    </script>
@endsection
