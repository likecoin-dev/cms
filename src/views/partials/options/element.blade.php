<div class="option-bar">

	<div class="option-body">
		
		<header>
			
			<h2>{{t('heading.option.bar_title')}}</h2>

		</header>

		<ul class="options list-unstyled">
			<li{{active('settings', $section)}}>
				<a href="{{route('element.settings', array('page_id' => $page_id, 'element_id' => $element_id))}}">{{t('heading.page.settings_title')}}</a>
			</li>
			<li{{active('content', $section)}}>
				<a href="{{route('element.content', array('page_id' => $page_id, 'element_id' => $element_id))}}">{{t('heading.element.content_title')}}</a>
			</li>
		</ul>

	</div>

</div>