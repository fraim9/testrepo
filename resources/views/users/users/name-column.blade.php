<div>
	<a href="{{ route('users.form', $user->id) }}">{{ $user->display_name }}</a>
</div>
<div class="text-smallest text-flat-light">
	{{ implode(', ', array_column($user->stores->toArray(), 'name', 'id')) }}
</div>

