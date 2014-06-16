<div class="tab-pane active" id="upload">
	
	<h3>{{ t('label.page.files.file_upload') }}</h3>

	<ul class="info-list list-unstyled highlight">
		<li>{{ t('label.page.files.max_upload') }}: <strong>{{ Pongo::settings('max_upload_size') }} Mb</strong></li>
		<li>{{ t('label.page.files.max_item') }}: <strong>{{ Pongo::settings('max_upload_items') }}</strong></li>
		<li>{{ t('label.page.files.mimes') }}: <strong>{{ Media::getMimes(true) }}</strong></li>
	</ul>

	<div id="fileuploader" class="btn btn-primary">{{ t('form.button.choose') }}</div>

</div>