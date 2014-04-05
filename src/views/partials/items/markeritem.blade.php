@foreach($items as $name => $marker)
	<li class="dl-item">

		<div class="dl-handle full">
			
			<big>{{$name}} <a href="#api" class="api-toggle">API</a></big>

			<p>{{Marker::description($name)}}.</p>
			<p class="api">{{Marker::api($name)}}</p>

		</div>
		
		<a href="#marker" class="edit insert" data-default="{{Marker::defaults($name)}}">
			<i class="fa fa-chevron-left"></i></a>

	</li>
@endforeach