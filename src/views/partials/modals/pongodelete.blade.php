<div class="modal fade {{ $target or 'pongo' }}-delete" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-center modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">{{ t('modal.title.are_you_sure') }}</h4>
			</div>
			<div class="modal-body buttons">
				{{ Form::open(array('route' => $route)) }}
				{{ Form::hidden('item_id') }}
				@if(isset($page_id))
				{{ Form::hidden('current_page', $page_id) }}
				@endif
				<button class="btn btn-sm btn-danger pongo-ajax-submit pongo-loading">{{ t('form.button.delete') }}</button>
				<button class="btn btn-sm btn-primary" data-dismiss="modal">{{ t('form.button.cancel') }}</button>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>