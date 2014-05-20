@if($is_image)
<a href="{{ $url }}" data-toggle="lightbox">
@else
<a href="{{ $url }}" target="_blank">
@endif
	{{ $output }}
</a>