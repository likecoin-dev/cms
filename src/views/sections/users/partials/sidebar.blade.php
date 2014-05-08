@if(isset($user))

	<ul class="side-menu">
		<li class="active">
			<a href="#settings" data-toggle="tab">{{ t('sidebar.page.settings') }}</a>
		</li>
		<li>
			<a href="#password" data-toggle="tab">{{ t('sidebar.user.password') }}</a>
		</li>
		<li>
			<a href="#details" data-toggle="tab">{{ t('sidebar.user.details') }}</a>
		</li>
	</ul>

@else

	<button id="search" class="btn btn-default search-toggle">
		<i class="fa fa-search"></i> {{ t('form.button.search') }}
	</button>

	<button id="create-user" class="btn btn-primary pongo-loading">
		<i class="fa fa-plus-circle"></i> {{ t('form.button.user') }}
	</button>

@endif