@foreach($items as $element)
	<li class="dl-item" data-id="{{$element->id}}">
		
		<a href="{{route('element.settings', array('page_id' => $page_id, 'element_id' => $element->id))}}"{{active($element->id, $element_id)}}>
			<i class="fa fa-chevron-left"></i>
		</a>

		<div class="dl-handle">
			
			<span>{{$element->name}}</span>

		</div>

		<label>
			<input type="checkbox" value="{{$element->id}}" {{Tool::isChecked($element->is_valid, 1)}} class="is_valid">
			<span></span>
		</label>

	</li>
@endforeach