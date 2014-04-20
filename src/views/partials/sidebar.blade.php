{{-- */ if(!isset($page_id)) $page_id = 0; /* --}}

<div class="sidebar left" id="pages">
			
	<div class="sidebar-wrapper">
		
		<header>
			
			<h2>{{t('heading.page.bar_title')}}</h2>

			<div class="page-controls">
				<i class="fa fa-plus-square" data-action="expand-all"></i>
				<i class="fa fa-minus-square" data-action="collapse-all"></i>
			</div>

			<select id="change-lang" class="form-control">
				@foreach(Pongo::settings('languages') as $lang_key => $lang)
					<option value="{{$lang_key}}"{{selected($lang_key, LANG)}}>{{$lang['lang']}}</option>
				@endforeach
			</select>

			<button id="create-page" class="btn btn-primary loading">
				<i class="fa fa-plus-circle"></i> {{t('form.button.page')}}
			</button>

		</header>
		
		@foreach(Pongo::settings('languages') as $lang_key => $lang)
		<div class="dd pages-wrapper" rel="{{$lang_key}}">
			
			<ol class="dd-list ol-nested left">

				{{Load::pageList(0, $lang_key, $page_id)}}

			</ol>

		</div>
		@endforeach

	</div>

</div>