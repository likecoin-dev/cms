{{-- */ if(!isset($role_id)) $role_id = 0; /* --}}
{{-- */ if(!isset($user_id)) $user_id = 0; /* --}}

<div class="right-bar">

	<div class="right-body">
		
		<ul class="multi-panel">

			<li>
				
				<header>

					<h2>{{t('heading.role.bar_title')}}</h2>

					<button id="create-role" class="btn btn-primary loading">
						<i class="fa fa-plus-circle"></i> {{t('form.button.role')}}
					</button>

				</header>

				<div class="dl">

					<ol class="dl-list">

						{{Access::roleList($role_id)}}

					</ol>

				</div>

			</li>

			<li>

				<header>

					<h2>{{t('heading.user.bar_title')}}</h2>
					
					<a href="#" id="search-toggle">
						<i class="fa fa-search"></i></a>

					<button id="create-user" class="btn btn-primary loading">
						<i class="fa fa-plus-circle"></i> {{t('form.button.user')}}
					</button>

				</header>

				{{Build::searchField('search', 'search', null, array('class' => 'form-control', 'placeholder' => t('form.placeholder.search'), 'data-item' => 'user'), array('username', 'email'))}}

				<div class="linked-pages user-list paginate">

					<form action="{{route('api.user.settings.valid')}}">

						<ol class="dd-list valid list">

							{{Access::userList($user_id)}}

						</ol>

					</form>

				</div>

			</li>

		</ul>	

	</div>

	<footer>
			
		<ul class="toolbar">
			<li class="active"><a href="#"><i class="fa fa-users"></i></a></li>
			<li><a href="#"><i class="fa fa-user"></i></a></li>
		</ul>

	</footer>

</div>