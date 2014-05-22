<div class="checkboxes">

	<label class="flag mini">

		<input type="checkbox" id="copy_all">
		<strong></strong>
		{{ t('label.page.settings.check_all_blocks') }}

	</label>
	
	<label class="flag mini">

		<input type="checkbox" name="file_all" value="1">
		<strong></strong>
		{{ t('label.page.settings.check_media_all') }}

	</label>

	<span>{{ t('label.block.modal.make_independent') }}</span>

</div>

<ol class="list-unstyled">
	@foreach($items as $block)
	<li>
		
		<p>{{ $block->name }}</p>

		<label for="block-{{$block->id}}" class="page">			
			<input type="checkbox" id="block-{{$block->id}}" name="blocks[]" value="{{$block->id}}" class="copy_block">			
			<strong></strong>
		</label>
		
		<label for="self-{{$block->id}}" class="self">			
			<input type="checkbox" id="self-{{$block->id}}" name="self_block[{{$block->id}}]" value="1">
			<strong></strong>
		</label>

	</li>
	@endforeach
</ol>