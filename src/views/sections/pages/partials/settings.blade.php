<div class="tab-pane active" id="settings">
						
	{{ Form::open(array('route' => 'api.page.save.settings')) }}

		{{ Form::hidden('id', $page->id) }}
		{{ Form::hidden('lang', $page->lang) }}
		{{ Form::hidden('section', 'settings') }}

		<div class="form-group" rel="name">
			
			{{ Form::label('name', t('label.page.settings.name')) }}
			
			{{ Form::text('name', $page->name, array('class' => 'form-control', 'placeholder' => t('placeholder.page.settings.name'), 'data-bind' => 'value: itemName, valueUpdate: "afterkeydown"')) }}

		</div>

		<div class="form-group" rel="slug">

			{{ Form::label('slug', t('label.page.settings.slug')) }}
			
			<div class="input-group">

				<span class="input-group-addon">/</span>
				
				{{ Form::text('slug', Tool::slugSlice($page->slug, 1), array('class' => 'form-control', 'placeholder' => t('placeholder.page.settings.slug'),  'data-bind' => 'value: pageSlug')) }}
				
				{{ Form::hidden('slug_previous', Tool::slugSlice($page->slug, 1))}}
				
				<span class="input-group-btn">

					<button class="btn btn-default" type="button" data-bind="click: createSlugThis">{{ t('label.page.settings.create_slug_this') }}</button>
					
					<button class="btn btn-default" type="button" data-bind="click: createSlugName">{{ t('label.page.settings.create_slug_name') }}</button>

				</span>

			</div>

			<span class="preview">{{ URL::to('/') }}<span>{{ Tool::slugBack($page->slug, 1) }}</span>/<span id="slug-last" data-bind="html: pageSlug"></span></span>

		</div>

		<div class="form-group" rel="role_level">
			
			{{ Form::label('role_level', t('label.page.settings.edit_by')) }}
			
			{{ Form::select('edit_level', Load::roleListArray('editors', true, true), $page->edit_level, array('class' => 'form-control', 'id' => 'view_level')) }}

		</div>

		<div class="form-group" rel="access_level">
			
			{{ Form::label('access_level', t('label.page.settings.view_by')) }}
			
			<div class="row">
				
				<div class="col-xs-2">
					{{ Form::select('view_access', Pongo::viewAccess(), $page->view_access, array('class' => 'form-control', 'id' => 'view_access')) }}
				</div>

				<div class="col-xs-10">
					
					{{ Form::select('view_level', Load::roleListArray('all', true), $page->view_level, array('class' => 'form-control', 'id' => 'view_level')) }}

				</div>

			</div>

		</div>

		<div class="form-group">

			<label for="is_home" class="flag home">

				{{ Form::checkbox('is_home', 1, $page->is_home, array('id' => 'is_home')) }}

				<span>{{t('label.page.settings.set_hp')}}</span>

			</label>

		</div>
		
		<div class="form-submit">
			<button class="btn btn-success pongo-ajax-submit pongo-loading">{{t('form.button.save')}}</button>
			<button class="btn btn-primary pongo-clone pongo-loading">{{t('form.button.clone')}}</button>
		</div>

	{{ Form::close() }}

</div>