@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 px-0">
        	<div class="block my-md-3 my-sm-2 my-0">
				<form method="post" action="{{ route('settings.store', $settings->_id) }}">
					@csrf
					<input type="hidden" name="doc[_id]" value="{{ $settings->_id }}">
	        		
	        		<div class="block-header block-header-default">
	        			<h3 class="block-title">{{ __('Set up') }} {{ $settings->_id }}</h3>
	        		</div>
					<div class="block-content">
						
						@if ($settings->_id == 'General')
						
							@include('helpers.formCheckbox', [
								'name' => 'doc[nameLat]', 
								'label' => __('Latin name entry'), 
								'value' => $settings->doc['nameLat'] ?? ''
							])
						
						@endif
						
						@if ($settings->_id == 'Storage')
						
							@include('helpers.formSelect', [
								'name' => 'doc[type]', 
								'label' => 'Type of storage', 
								'value' => $settings->doc['type'] ?? '',
								'options' => array_column($storageTypes, 'name', 'id'),
								'required' => true,
							])
						
							<hr>
							<h6>Local</h6>
							
							@include('helpers.formText', [
								'name' => 'doc[localStorage][folderPath]', 
								'label' => 'Folder path', 
								'value' => $settings->doc['localStorage']['folderPath'] ?? ''
							])

							@include('helpers.formText', [
								'name' => 'doc[localStorage][folderPathCold]', 
								'label' => 'Folder path (cold)', 
								'value' => $settings->doc['localStorage']['folderPathCold'] ?? ''
							])
							
							<hr>
							<h6>S3 object storage</h6>
							
							@include('helpers.formText', [
								'name' => 'doc[objectStorage][server]', 
								'label' => 'Server', 
								'value' => $settings->doc['objectStorage']['server'] ?? ''
							])

							@include('helpers.formText', [
								'name' => 'doc[objectStorage][bucket]', 
								'label' => 'Bucket', 
								'value' => $settings->doc['objectStorage']['bucket'] ?? ''
							])

							@include('helpers.formText', [
								'name' => 'doc[objectStorage][accessKey]', 
								'label' => 'Access Key', 
								'value' => $settings->doc['objectStorage']['accessKey'] ?? ''
							])
							
							
							
						@endif


						@if ($settings->_id == 'iPOS')
							
							<div class="form-group row">
								<div class="col-md-4">
									<label>{{ __('Список распознаваемых типов штрих-кодов товаров') }}</label>
								</div>
								<div class="col-md-8">
									@if ($barcodes)
        								@foreach ($barcodes as $barcode)
        									<div class="custom-control custom-switch pb-1">
                                                <input type="checkbox" class="custom-control-input" value="{{ $barcode->id }}"
                                                	id="code1_{{ $barcode->id }}" name="doc[barcodes][itemBarcodeTypes][]" {{ (isset($settings->doc['barcodes']['itemBarcodeTypes']) && in_array($barcode->id, $settings->doc['barcodes']['itemBarcodeTypes'])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="code1_{{ $barcode->id }}">{{ $barcode->name }}</label>
                                    		</div>
        								@endforeach
        							@endif
								</div>
							
							</div>
							
							<div class="form-group row">
								<div class="col-md-4">
									<label>{{ __('Список распознаваемых типов штрих-кодов карт клиента') }}</label>
								</div>
								<div class="col-md-8">
									@if ($barcodes)
        								@foreach ($barcodes as $barcode)
        									<div class="custom-control custom-switch pb-1">
                                                <input type="checkbox" class="custom-control-input" value="{{ $barcode->id }}"
                                                	id="code2_{{ $barcode->id }}" name="doc[barcodes][clientBarcodeTypes][]" {{ (isset($settings->doc['barcodes']['clientBarcodeTypes']) && in_array($barcode->id, $settings->doc['barcodes']['clientBarcodeTypes'])) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="code2_{{ $barcode->id }}">{{ $barcode->name }}</label>
                                    		</div>
        								@endforeach
        							@endif
								</div>
							
							</div>

						@endif
						
						@if ($settings->_id == 'OmniPOS')
							
							<hr>
							<h6>API</h6>
							
							@include('helpers.formText', [
								'name' => 'doc[api][url]', 
								'label' => 'URL', 
								'value' => $settings->doc['api']['url'] ?? '',
							])
							
							@include('helpers.formText', [
								'name' => 'doc[api][secretKey]', 
								'label' => 'Secret Key', 
								'value' => $settings->doc['api']['secretKey'] ?? '',
							])
							
							
						@endif
						
					</div>
					
					@include('helpers.formButtons')
					
				</form>
	        
	        </div>
	    </div>
	</div>
</div>
@endsection

