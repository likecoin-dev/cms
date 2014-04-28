<div class="tab-pane active" id="settings">
						
	{{ Form::open(array('route' => 'api.page.save')) }}
		{{ Form::hidden('submit', 'settings') }}
		<div class="form-group" rel="name">
			{{ Form::label('name', t('label.page.settings.name')) }}
			<input type="text" class="form-control" name="name" id="name" placeholder="{{t('placeholder.page.settings.name')}}" value="{{{$name or null}}}">
		</div>
		<div class="form-group" rel="slug">
			{{ Form::label('slug', t('label.page.settings.slug')) }}
			<div class="input-group">
				<span class="input-group-addon">/</span>
				<input type="text" class="form-control" name="slug" id="slug" placeholder="{{t('placeholder.page.settings.slug')}}" value="{{{$slug or null}}}">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button">{{t('label.page.settings.create_slug')}}</button>
				</span>
			</div>
			<span class="preview">http://www.mysite.com/sub-page</span>
		</div>
		<div class="form-group" rel="role_level">
			{{ Form::label('role_level', t('label.page.settings.edit_by')) }}
			<select class="form-control" name="role_level" id="role_level">
				<option value="">Admin</option>
			</select>
		</div>
		<div class="form-group" rel="access_level">
			{{ Form::label('access_level', t('label.page.settings.view_by')) }}
			<select class="form-control" name="access_level" id="access_level">
				<option value="">Guest</option>
			</select>
		</div>
		<div class="form-group">
			<label for="is_home" class="flag home">
				<input type="checkbox" id="is_home" name="is_home" value="1">
				<span>{{t('label.page.settings.set_hp')}}</span>
			</label>
		</div>
		<div class="form-submit">
			<button class="btn btn-success pongo-save">{{t('form.button.save')}}</button>
			<button class="btn btn-primary pongo-clone">{{t('form.button.clone')}}</button>
			<button class="btn btn-danger pongo-delete">{{t('form.button.delete')}}</button>
		</div>
	{{ Form::close() }}

</div>