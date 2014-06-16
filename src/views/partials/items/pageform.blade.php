@foreach($items as $key => $page)

	@if($parent_id > 0 and $key == 0)
	
	<ol>
	
	@endif

		<li>

			<p>{{ $page->name }}</p>

			<label for="page-{{$page->id}}" class="page">
				<input type="checkbox" id="page-{{$page->id}}" name="pages[]" value="{{$page->id}}" class="copy_block">			
				<strong></strong>
			</label>
			
			<label for="self-{{$page->id}}" class="self">
				<input type="checkbox" id="self-{{$page->id}}" name="self_block[{{$page->id}}]" value="1">
				<strong></strong>
			</label>

			@if($page->id > 0)

				{{ Load::pageList($page->id, $page->lang, $page_id, 'pageform') }}

			@endif

		</li>

	@if($parent_id > 0 and $key == $count - 1)

	</ol>
	
	@endif

@endforeach