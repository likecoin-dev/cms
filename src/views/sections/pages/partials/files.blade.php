<div class="tab-pane" id="file">
	
	<div class="tab-wrapper">

		<div class="row">

			<div class="col-xs-8 upload">
				
				<h3>{{ t('label.page.files.file_create') }}</h3>

				<ul class="info-list list-unstyled highlight">
					<li>{{ t('label.page.files.max_upload') }}: <strong>{{ Pongo::settings('max_upload_size') }} Mb</strong></li>
					<li>{{ t('label.page.files.max_item') }}: <strong>{{ Pongo::settings('max_upload_items') }}</strong></li>
					<li>{{ t('label.page.files.mimes') }}: <strong>{{ Media::getMimes(true) }}</strong></li>
				</ul>

				<div id="fileuploader" class="btn btn-primary">{{ t('form.button.choose') }}</div>

			</div>		

			<div class="col-xs-4">

				<h3 class="to-right">{{ t('label.page.files.page_files') }}</h3>

				{{ Form::open(array('route' => 'api.file.valid')) }}

				<div class="scroll-700 pongo-checking pongo-confirming pongo-paginating">
				
					<ol class="ol-list hi pongo-active pongo-update pongo-lightbox">

						@if($page->files->count())

							@foreach($page->files_paginated as $file)
								
								<li class="file-item" data-id="{{ $file->id }}">

									<p>
										{{ Media::showThumb($file->path) }}
										<span>{{ Tool::maxFileName($file->name, $file->ext, 30) }}</span>		
									</p>

									<label>
										<input type="checkbox" value="{{$file->id}}" class="pongo-checkbox"{{ checked($file->pivot->is_active, 1) }}>
										<strong></strong>
									</label>

									<div class="btn-edit">
												
										<a href="{{ route('file.edit', array('file_id' => $file->id)) }}" class="btn btn-sm btn-primary">
											<i class="fa fa-pencil-square-o"></i></a>
										
										<a href="#" data-toggle="modal" data-target=".file-delete" data-id="{{ $file->id }}" class="btn btn-sm btn-danger pongo-confirm">
											<i class="fa fa-trash-o"></i></a>
									
									</div>

								</li>

							@endforeach

						@else

							{{ Render::noResult('empty') }}

						@endif

					</ol>

					{{ $page->files_paginated->links() }}

				</div>

				{{ Form::close() }}

			</div>

		</div>

	</div>

</div>