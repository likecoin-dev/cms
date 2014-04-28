@if(isset($role))

	<ul class="side-menu">
		<li class="active">
			<a href="#settings" data-toggle="tab">{{t('sidebar.page.settings')}}</a>
		</li>
	</ul>

@else

	<button id="create-role" class="btn btn-primary pongo-loading">
		<i class="fa fa-plus-circle"></i> {{t('form.button.role')}}
	</button>

@endif