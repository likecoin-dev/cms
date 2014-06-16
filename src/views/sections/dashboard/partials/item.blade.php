<ul class="page-menu">

	@foreach($items as $key => $item)
		
		@if( array_key_exists('route', $item) or array_key_exists('class', $item) )

			@if( ! array_key_exists('route', $item) and array_key_exists('class', $item) )

			<li>

				<a href="#" class="{{ $item['class'] }}">

					<span class="fa-stack fa-lg">

						<i class="fa fa-square-o fa-stack-2x"></i>

						<i class="fa {{ $item['dashb_icon'] }} fa-stack-1x"></i>

					</span>

					<span>{{ t('menu.'.$key) }}</span>

				</a>

			</li>

			@endif

			@if( array_key_exists('dashb_icon', $item) and !array_key_exists('class', $item) )

			<li>

				<a href="{{ route($item['route']) }}">

					<span class="fa-stack fa-lg">

						<i class="fa fa-square-o fa-stack-2x"></i>

						<i class="fa {{ $item['dashb_icon'] }} fa-stack-1x"></i>

					</span>

					<span>{{ t('menu.'.$key) }}</span>

				</a>

			</li>

			@endif

		@endif

	@endforeach
	
</ul>