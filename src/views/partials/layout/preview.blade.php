<div class="layout-wrapper {{ $size }} {{ $toggle_class }}">
					
	<span data-name="template">{{ st('settings.template.' . $template, Theme::config('template.' . $template)) }}</span>

	<div class="row">

		<div class="col-xs-12" data-name="header">

			{{ st('settings.header.' . $header, Theme::config('header.' . $header)) }}

		</div>

	</div>

	{{ Render::layoutPreview($layout, $print_name, $checked_zone) }}

	<div class="row">

		<div class="col-xs-12" data-name="footer">

			{{ st('settings.footer.' . $footer, Theme::config('footer.' . $footer)) }}

		</div>

	</div>

</div>