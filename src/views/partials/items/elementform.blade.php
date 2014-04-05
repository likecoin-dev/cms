@foreach($items as $element)

	<li>

		<div class="clone-item">

			<label for="element-{{$element->id}}" class="page">
				<input type="checkbox" id="element-{{$element->id}}" name="elements[]" value="{{$element->id}}" class="cloned_element">
				{{$element->name}}
			</label>
			
			<label for="self-{{$element->id}}" class="self">
				{{t('label.element.settings.self_element')}}
				<input type="checkbox" id="self-{{$element->id}}" name="self_elements[{{$element->id}}]" value="1">
			</label>

		</div>

	</li>

@endforeach