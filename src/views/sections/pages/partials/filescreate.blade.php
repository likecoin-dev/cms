<div class="tab-pane" id="create">
	
	<h3>{{ t('label.page.files.file_create') }}</h3>

	<ul class="info-list list-unstyled highlight">

		<li>{{ t('label.page.files.mimes') }}: <strong>{{ Media::getMimes(true) }}</strong></li>

		<li class="print"></li>

	</ul>

	{{ Form::open(array('route' => 'api.file.create')) }}

		{{ Form::hidden('id', $page['id']) }}
		{{ Form::hidden('lang', $page['lang']) }}
		{{ Form::hidden('section', 'create') }}

		<div class="form-group" rel="file_size">
			
			{{ Form::label('size', t('label.page.files.file_size')) }}
			
			<div class="row">
				
				<div class="col-xs-3">

					{{ Form::text('file_size', null, array('class' => 'form-control', 'placeholder' => t('placeholder.page.files.size'))) }}

				</div>
				
				<div class="col-xs-2">

					{{ Form::select('size_type', array('kb' => 'Kb', 'mb' => 'Mb'), null, array('class' => 'form-control', 'id' => 'size_type')) }}

				</div>

			</div>

		</div>

		<div class="form-group" rel="file_name">
			
			{{ Form::label('file_name', t('label.page.files.file_name')) }}

			{{ Form::text('file_name', null, array('class' => 'form-control', 'placeholder' => t('placeholder.page.files.name'))) }}

		</div>
		
		<div class="form-submit">

			<button class="btn btn-success pongo-ajax-submit pongo-loading">{{ t('form.button.save') }}</button>

		</div>

	{{ Form::close() }}

</div>