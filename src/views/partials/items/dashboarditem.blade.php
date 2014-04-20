<ul class="page-menu">
	@foreach($items as $key => $item)
		@if(array_key_exists('dashb_icon', $item))
		<li>
			<a href="{{route($item['route'])}}" class="pages-toggle">
				<span class="fa-stack fa-lg">
					<i class="fa fa-square-o fa-stack-2x"></i>
					<i class="fa {{$item['dashb_icon']}} fa-stack-1x"></i>
				</span>
				{{t('menu.'.$key)}}
			</a>
		</li>
		@endif
	@endforeach
</ul>