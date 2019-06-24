<form action="{{ $url }}" method="post"
	onsubmit="return confirm('{{ __($confirm) }}');">
	@csrf
	@method('DELETE')
	<button class="btn btn-sm btn-light" type="submit" title="{{ __($title) }}"
		><i class="fa fa-fw fa-times"></i></button>
</form>