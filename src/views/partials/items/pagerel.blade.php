@foreach($items as $key => $item)

	@if($parent_id > 0)
	<ol class="dd-list">
	@endif
	
	@if($page_id != $item->id)
	<li class="dd-item" data-id="{{$item->id}}">
		
		<div class="dd-handle">

			{{$item->name}}

			<label>
				<input type="checkbox" value="{{$item->id}}" {{Tool::isChecked($item->id, $page_rels)}} class="page_rel">
				<span></span>
			</label>

		</div>

		@if($item->id > 0)

			{{Load::pageList($item->id, $item->lang, $page_id, $partial)}}

		@endif

	</li>
	@endif

	@if($parent_id > 0)
	</ol>
	@endif

@endforeach