<div class="scroll">

	<ol class="tool-list">

	@foreach($items as $name => $marker)
		<li>

			<div>
				
				<big>{{ $name }} <a href="#api" class="api-toggle">API</a></big>

				<p>{{ Marker::description($name) }}</p>
				<p class="api">{{ Marker::api($name) }}<p>

			</div>
			
			<a href="#marker" class="pongo-insert" data-default="{{ Marker::defaults($name) }}">
				<i class="fa fa-chevron-right"></i></a>

		</li>
	@endforeach

	</ol>

</div>