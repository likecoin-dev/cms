<div class="modal fade page-copy" tabindex="-1" role="dialog" aria-hidden="true">

	<div class="modal-dialog modal-dialog-center">
		
		{{ Form::open(array('route' => $route)) }}

		{{ Form::hidden('page_id', $page_id) }}

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

				<h4 class="modal-title">{{ t('modal.title.copy_page') }}</h4>

			</div>

			<div class="modal-body">
				
				<div class="form-group" rel="copy-lang">
					
					{{ Form::label('copy_lang', t('modal.label.which_language')) }}
					{{ Form::select('copy_lang', Pongo::languages(), LANG, array('id' => 'copy-lang', 'class' => 'form-control')) }}

				</div>

				<div class="form-group copy">

					{{ Load::blockForm($page_id) }}

				</div>

			</div>

			<div class="modal-footer buttons">

				<button class="btn btn-sm btn-primary pongo-ajax-submit pongo-loading">{{ t('form.button.copy') }}</button>

				<button class="btn btn-sm btn-danger" data-dismiss="modal">{{ t('form.button.cancel') }}</button>

			</div>

		</div>

		{{ Form::close() }}

	</div>

</div>