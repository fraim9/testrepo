<?php
/*
$title
$btns = [
    [
        'class' => 'btn btn-default',
        'caption' => 'name of action',
        'url' => 'some-url-of-action'
    ],
    [
        ...
    ]
]

*/
?>

<!-- Hero -->
<div class="bg-body-light">
    <div class="content py-2">
		<div class="row">
			<div class="col-6">
				<h1 class="h3 my-1">{{ __($title) }}</h1>
			</div>
			<div class="col-6 text-right">
				@isset($btns)
            		@foreach ($btns as $btn)
            			<a href="{{ $btn['url'] }}" class="{{ $btn['class'] }}">{{ __($btn['caption']) }}</a>
            		@endforeach
            	@endisset
			</div>
		
		</div>    
   </div>
</div>
<!-- END Hero -->