<ol class="breadcrumb">
	<li>{{strtoupper(LANG)}}</li>
	@foreach($routes as $route)
	<li>{{link_to_route($sections[$route]['route'], t('menu.' . $route))}}</li>
	@endforeach
</ol>