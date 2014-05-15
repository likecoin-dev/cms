<div class="tab-pane" id="layout">

	{{ Form::open(array('route' => 'api.page.save.layout')) }}

		{{ Form::hidden('id', $page->id) }}
		{{ Form::hidden('lang', $page->lang) }}
		{{ Form::hidden('section', 'layout') }}

		<div class="row">

			<div class="col-xs-3 pongo-layout-changing">
				
				<div class="form-group" rel="template">

					{{ Form::label('template', t('label.page.layout.template')) }}

					{{ Form::select('template', Theme::config('template'), $page->template, array('class' => 'form-control')) }}

				</div>

				<div class="form-group" rel="header">

					{{ Form::label('header', t('label.page.layout.header')) }}

					{{ Form::select('header', Theme::config('header'), $page->header, array('class' => 'form-control')) }}

				</div>

				<div class="form-group" rel="layout">

					{{ Form::label('layout', t('label.page.layout.layout')) }}

					{{ Form::select('layout', Theme::config('layout'), $page->layout, array('class' => 'form-control')) }}

				</div>

				<div class="form-group" rel="footer">

					{{ Form::label('footer', t('label.page.layout.footer')) }}

					{{ Form::select('footer', Theme::config('footer'), $page->footer, array('class' => 'form-control')) }}

				</div>

			</div>

			<div class="col-xs-9">
				
				<label class="right">{{ t('label.page.layout.overall') }}</label>

				<div class="layout-wrapper pongo-blocks-loading">
					
					<span data-name="template">{{ st('settings.template.' . $page->template, Theme::config('template.' . $page->template)) }}</span>

					<div class="row">
	
						<div class="col-xs-12" data-name="header">

							{{ st('settings.header.' . $page->header, Theme::config('header.' . $page->header)) }}

						</div>

					</div>

					{{ Render::layoutPreview($page->layout) }}

					<div class="row">
	
						<div class="col-xs-12" data-name="footer">

							{{ st('settings.footer.' . $page->footer, Theme::config('footer.' . $page->footer)) }}

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="form-submit">
			<button class="btn btn-success pongo-ajax-submit pongo-loading">{{t('form.button.save')}}</button>
		</div>

	{{ Form::close() }}

</div>