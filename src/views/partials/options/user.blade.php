<div class="option-bar">

	<div class="option-body">
		
		<header>
			
			<h2>{{t('heading.option.bar_title')}}</h2>

		</header>
		
		<ul class="options list-unstyled">
			<li{{active('settings', $section)}}>
				<a href="{{route('user.settings', array('user_id' => $user_id))}}">{{t('heading.page.settings_title')}}</a>
			</li>
			<li{{active('password', $section)}}>
				<a href="{{route('user.password', array('user_id' => $user_id))}}">{{t('heading.user.password_title')}}</a>
			</li>
			<li{{active('details', $section)}}>
				<a href="{{route('user.details', array('user_id' => $user_id))}}">{{t('heading.user.details_title')}}</a>
			</li>
		</ul>

	</div>

</div>