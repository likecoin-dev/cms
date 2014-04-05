@foreach($items as $page)

	@if($parent_id > 0)
	<ol>
	@endif

		<li>

			<div class="clone-item">

				<label for="page-{{$page->id}}" class="page">
					<input type="checkbox" id="page-{{$page->id}}" name="pages[]" value="{{$page->id}}">
					{{$page->name}}
				</label>
				
				<label for="self-{{$page->id}}" class="self{{Tool::addActive($page->id, $page_id)}}">
					{{t('label.element.settings.self_element')}}
					<input type="checkbox" id="self-{{$page->id}}" name="self_elements[{{$page->id}}]" value="1">
				</label>

			</div>

			@if($page->id > 0)
				{{Load::pageForm($page->id, $page->lang, $page_id)}}
			@endif
		</li>

	@if($parent_id > 0)
	</ol>
	@endif

@endforeach