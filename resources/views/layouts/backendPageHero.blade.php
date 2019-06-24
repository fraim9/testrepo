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
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">{{ __($title) }}</h1>
            <div class="flex-sm-00-auto ml-sm-3">
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