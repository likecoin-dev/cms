<div class="tab-pane" id="file">
	
	<div class="tab-wrapper">

		<div class="row">

			<div class="col-xs-8 upload">

				@include('cms::sections.pages.partials.filestab')

				<div class="tab-content">
					
					@include('cms::sections.pages.partials.filesupload', array('page' => $page))

					@include('cms::sections.pages.partials.filescreate', array('page' => $page))

				</div>

			</div>		

			<div class="col-xs-4">

				<h3 class="to-right">{{ t('label.page.files.page_files') }}</h3>

				{{ Form::open(array('route' => 'api.file.valid')) }}

				<div class="scroll-700">

					<div class="scroll pongo-checking pongo-confirming pongo-paginating">
				
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

				</div>

				{{ Form::close() }}

			</div>

		</div>

	</div>

</div>