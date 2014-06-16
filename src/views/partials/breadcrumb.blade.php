<ol class="breadcrumb">

	<li>{{ Render::currentLanguage() }}</li>

	@foreach($routes as $route)

		<li>{{ link_to_route($sections[$route]['route'], t('menu.' . $route)) }}</li>

	@endforeach

	@if(isset($page))

		<li>{{ link_to('#', t('menu.pages'), array('class' => 'pages-toggle')) }}</li>

		@if((isset($last) and ! is_a($page, 'Pongo\Cms\Models\Page')) or (isset($zone)))

			<li>{{ link_to_route('page.edit', $page->name, array('page_id' => $page->id), array('class' => 'pongo-slug', 'data-slug' => $page->seo->first()->slug)) }}</li>

		@endif

	@endif

	@if(isset($zone))
		
		<li class="zone-name">{{ $zone }}</li>

	@endif

	@if($last)

		<li data-bind="html: itemName">{{ $last }}</li>

	@endif
	
</ol>