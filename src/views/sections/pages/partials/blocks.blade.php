{{-- */ if(!isset($block_id)) $block_id = 0; /* --}}

<div class="sidebar right" id="options">
		
	<div class="sidebar-wrapper">
		
		<header>
			
			<h2><span></span> {{ t('sidebar.page.blocks') }}</h2>

			<button id="create-block" class="btn btn-primary right pongo-loading">
				<i class="fa fa-plus-circle"></i> {{t('form.button.block')}}
			</button>

		</header>
		
		{{ Form::open(array('route' => 'api.block.valid')) }}

		<div class="db nestable blocks-wrapper pongo-moving pongo-checking pongo-deleting pongo-confirming">
			
			<ol class="db-list ol-nested right pongo-active">

			</ol>

		</div>

		{{ Form::close() }}

	</div>

</div>