<div class="row">
	<nav class="navbar navbar-inverse" role="navigation">
		<button type="button" class="toggle page-toggle">
			<i class="fa fa-file-text"></i>
		</button>
		<button type="button" class="toggle menu-toggle" data-toggle="collapse" data-target=".menu-collapse">
			<i class="fa fa-bars"></i>
		</button>
		<div class="navbar-header">
			<a class="navbar-brand" href="{{route('dashboard')}}">Pongo<span>CMS</span> <small>v2</small></a>	
		</div>

		<div class="collapse navbar-collapse menu-collapse">
			<ul class="nav navbar-nav">
			{{Render::sectionMenu()}}
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user"></i>
						{{USERNAME}} <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li class="dropdown-header">{{t('menu.cmslang')}}:</li>
						@foreach(Pongo::settings('languages') as $lang => $language)
						<li{{active($lang, CMSLANG)}}>
							{{link_to_route('lang', $language['lang'], array('lang' => $lang))}}
						</li>
						@endforeach
						<li class="divider"></li>
						<li>{{link_to_route('logout', 'Logout')}}</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</div>