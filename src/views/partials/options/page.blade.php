<div class="option-bar">

	<div class="option-body">
		
		<header>
			
			<h2>{{t('heading.option.bar_title')}}</h2>

		</header>
		
		<ul class="options list-unstyled">
			<li{{active('settings', $section)}}>
				<a href="{{route('page.settings', array('page_id' => $page_id))}}">{{t('heading.page.settings_title')}}</a>
			</li>
			<li{{active('layout', $section)}}>
				<a href="{{route('page.layout', array('page_id' => $page_id))}}">{{t('heading.page.layout_title')}}</a>
			</li>
			<li{{active('seo', $section)}}>
				<a href="{{route('page.seo', array('page_id' => $page_id))}}">{{t('heading.page.seo_title')}}</a>
			</li>
			<li{{active('files', $section)}}>
				<a href="{{route('page.files', array('page_id' => $page_id))}}">{{t('heading.page.files_title')}}</a>
			</li>
		</ul>

	</div>

</div>