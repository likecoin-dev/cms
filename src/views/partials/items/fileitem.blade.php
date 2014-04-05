@foreach($items as $file)
	<li class="dl-item" data-id="{{$file->id}}">

		<div class="dl-handle">
			
			@if(Media::isImage($file->name))
				<a href="{{$file->path}}" class="popup">
					{{Image::showThumb($file->path)}}</a>
			@else
				<a href="{{route('file.edit', array('file_id' => $file->id))}}">
					{{Image::showThumb($file->path)}}</a>
			@endif

			<span>{{Media::formatFileName($file->name, false)}}</span>
			
			<div>
				<span class="ext">{{$file->ext}}</span>
				<span class="size">{{Media::getFileInfo($file)}}</span>
			</div>

		</div>
		
		@if($action == 'edit')
			<a href="{{route('file.edit', array('file_id' => $file->id))}}" class="edit">
				<i class="fa fa-chevron-left"></i></a>
		@else

			@if(Media::isImage($file->name))
				<a href="#image" data-default="{{asset($file->path)}}" data-tag="img" class="edit insert">
				<i class="fa fa-chevron-left"></i></a>
			@else
				<a href="#file" data-default="[$FILE[file:{{$file->name}}]]" class="edit insert">
				<i class="fa fa-chevron-left"></i></a>
			@endif
			
		@endif

		<a href="{{route('api.page.files.delete', array('file_id' => $file->id))}}" class="remove confirm">
			<i class="fa fa-times"></i>
		</a>

	</li>
@endforeach