@if($is_image)
<a href="{{ $url }}" data-toggle="lightbox" class="pongo-img">
@else
<a href="{{ $url }}" target="_blank" class="pongo-file">
@endif
	{{ $output }}
</a>