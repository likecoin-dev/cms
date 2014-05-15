@foreach($items as $key => $item)

	@if($parent_id > 0 and $key == 0)
	<ol class="dd-list">
	@endif

	<li class="dd-item move" data-id="{{ $item->id }}">
		<p class="dd-handle">{{Tool::isHome($item->is_home)}}<span>{{$item->name}}</span></p>
		<label><input type="checkbox" value="{{ $item->id }}" class="pongo-checkbox"{{ checked($item->is_active, 1) }}><span></span></label>
		@if($item->is_active)
		<a href="{{ route('page.edit', array('page_id' => $item->id)) }}" data-link="page" data-arrow="right" data-id="{{ $item->id }}"{{ active($item->id, $page_id) }}>
			<i class="fa fa-chevron-right"></i>
		</a>
		@else
		<a href="#" data-link="page" data-arrow="right" data-toggle="modal" data-target=".page-delete" data-id="{{ $item->id }}" class="pongo-confirm">
			<i class="fa fa-trash-o"></i>
		</a>
		@endif

		@if($item->id > 0)
			{{Load::pageList($item->id, $item->lang, $page_id, $partial)}}
		@endif
	</li>

	@if($parent_id > 0 and $key == $count-1)
	</ol>
	@endif

@endforeach