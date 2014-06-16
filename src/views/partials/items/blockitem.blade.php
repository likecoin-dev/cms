@foreach($items as $key => $item)

	<li class="dd-item move" data-id="{{ $item->id }}">

		<p class="dd-handle">{{$item->name}}</p>

		@if($item->is_active)

			<label><input type="checkbox" value="{{ $item->id }}" data-page="{{ $page_id }}" class="pongo-checkbox"><strong></strong></label>

			<a href="#" data-link="block" data-arrow="left" data-toggle="modal" data-target=".pongo-delete" data-id="{{ $item->id }}" class="pongo-confirm">
				<i class="fa fa-trash-o"></i>
			</a>

		@else

			<label><input type="checkbox" value="{{ $item->id }}" data-page="{{ $page_id }}" class="pongo-checkbox" checked="checked"><strong></strong></label>
			
			<a href="{{ route('block.edit', array('page_id' => $page_id, 'block_id' => $item->id)) }}" data-link="block" data-arrow="left" data-id="{{ $item->id }}"{{ active($item->id, $block_id) }}>
				<i class="fa fa-chevron-left"></i>
			</a>

		@endif

	</li>

@endforeach