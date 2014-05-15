<ol class="breadcrumb">
	<li>{{ Render::currentLanguage() }}</li>
	@foreach($routes as $route)
	<li>{{ link_to_route($sections[$route]['route'], t('menu.' . $route)) }}</li>
	@endforeach
	@if($last)
	<li data-bind="html: itemName">{{ $last }}</li>
	@endif
</ol>