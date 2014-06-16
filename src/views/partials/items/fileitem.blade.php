<div class="scroll pongo-paginating">

	<ol class="tool-list pongo-update pongo-lightbox">

	@foreach($items as $file)
		<li class="file-item">			

			@if(Media::isImage($file->name))

				<div>

					{{ Media::showThumb($file->path) }}

					<p>{{Media::formatFileName($file->name, true)}}</p>

				</div>

				<a href="{{ $file->name }}" class="pongo-insert" data-tag="img">
					<i class="fa fa-chevron-right"></i></a>

			@else

				<div>

					{{ Media::showThumb($file->path) }}

					<p>{{Media::formatFileName($file->name, true)}}</p>

				</div>

				<a href="{{ $file->name }}" class="pongo-insert" data-tag="file">
					<i class="fa fa-chevron-right"></i></a>

			@endif

		</li>
	@endforeach

	</ol>

	{{ $items->links() }}

</div>