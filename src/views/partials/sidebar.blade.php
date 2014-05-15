{{-- */ if(!isset($page_id)) $page_id = 0; /* --}}

<div class="sidebar left" id="pages">

	<div class="sidebar-wrapper">
		
		<header>

			<h2>{{t('sidebar.pages.header')}}</h2>

			<div class="page-controls">
				<i class="fa fa-plus-square" data-action="expand-all"></i>
				<i class="fa fa-minus-square" data-action="collapse-all"></i>
			</div>

			{{ Form::select('change-lang', Pongo::languages(), LANG, array('id' => 'change-lang', 'class' => 'form-control')) }}

			<button id="create-page" class="btn btn-primary pongo-loading">
				<i class="fa fa-plus-circle"></i> {{t('form.button.page')}}
			</button>

		</header>

		{{ Form::open(array('route' => 'api.page.valid')) }}

		@foreach(Pongo::settings('languages') as $lang_key => $lang)
		
		<div class="dd nestable pages-wrapper pongo-moving pongo-checking pongo-deleting pongo-confirming" rel="{{$lang_key}}">
			
			<ol class="dd-list ol-nested left pongo-active">

				{{ Load::pageList(0, $lang_key, $page_id) }}

			</ol>

		</div>
		
		@endforeach
		
		{{ Form::close() }}

	</div>

</div>