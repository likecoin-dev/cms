<div class="tab-pane active" id="content">
	
	<div class="tab-wrapper">

		<div class="row">

			<div class="col-xs-3 tools">

				@include('cms::sections.blocks.partials.toolstab')
				
				<div class="tab-content">
					
					@include('cms::sections.blocks.partials.files')

					@include('cms::sections.blocks.partials.markers')

				</div>

			</div>

			<div class="col-xs-9 editor">
		
				<div id="edit">

					{{ $block->content }}

				</div>

				<div class="form-submit">
					<button class="btn btn-success froala-ajax-submit pongo-loading">{{ t('form.button.save') }}</button>
					<button class="btn btn-primary pongo-live-on pongo-loading">{{ t('form.button.live') }}</button>
				</div>

			</div>

		</div>

	</div>

</div>