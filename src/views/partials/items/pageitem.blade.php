@foreach($items as $key => $item)

	@if($parent_id > 0 and $key == 0)
	<ol class="dd-list">
	@endif

	<li class="dd-item" data-id="{{$item->id}}">

		<p class="dd-handle">{{Tool::isHome($item->is_home)}}{{$item->name}}</p>
		
		@if($item->id > 0)

			{{Load::pageList($item->id, $item->lang, $page_id, $partial)}}

		@endif

		<label><input type="checkbox"{{Tool::isChecked($item->is_valid, 1)}}><span></span></label>
		
		<a href="{{route('page', array('page_id' => $item->id))}}"{{active($item->id, $page_id)}}>			
			<i class="fa fa-chevron-right"></i>
		</a>

	</li>

	@if($parent_id > 0 and $key == $count-1)
	</ol>
	@endif

@endforeach