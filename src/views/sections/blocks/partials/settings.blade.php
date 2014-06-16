<div class="tab-pane" id="settings">

	{{ Form::open(array('route' => 'api.block.save.settings')) }}

		{{ Form::hidden('id', $block->id) }}
		{{ Form::hidden('page_id', $page_id) }}
		{{ Form::hidden('lang', LANG) }}
		{{ Form::hidden('section', 'settings') }}

		<div class="form-group" rel="name">
			
			{{ Form::label('name', t('label.block.settings.name')) }}

			{{ Form::text('name', $block->name, array('class' => 'form-control', 'placeholder' => t('placeholder.block.settings.name'), 'data-bind' => 'value: itemName, valueUpdate: "afterkeydown"')) }}

		</div>

		<div class="form-group" rel="attrib">

			{{ Form::label('attrib', t('label.block.settings.attrib')) }}
			
			<div class="input-group">

				<span class="input-group-addon">#</span>
				
				{{ Form::text('attrib', $block->attrib, array('class' => 'form-control', 'placeholder' => t('placeholder.block.settings.attrib'),  'data-bind' => 'value: blockAttrib')) }}
				
				<span class="input-group-btn">
					
					<button class="btn btn-default" type="button" data-bind="click: createAttrib">{{ t('label.block.settings.create_attrib') }}</button>

				</span>

			</div>

		</div>

		<div class="form-group" rel="zone">
				
			{{ Form::label('zone', t('label.block.settings.zone')) }}

			{{ Load::blockZones($page_id, $block->id, $block->zone, 'zone', 'update-zone') }}

		</div>

		<div class="form-submit">
			<button class="btn btn-success pongo-ajax-submit pongo-loading">{{ t('form.button.save') }}</button>
			<a href="#" data-toggle="modal" data-target=".block-copy" class="btn btn-primary pongo-copy pongo-loading">{{ t('form.button.copy') }}</a>
		</div>

	{{ Form::close() }}

</div>