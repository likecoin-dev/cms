{{-- */ if(!isset($element_id)) $element_id = 0; /* --}}

<div class="right-bar">

	<div class="right-body multi">
	
		<ul class="multi-panel">

			<li>

				<header>

					<h2>{{t('heading.layout.bar_title')}}</h2>

				</header>

				<div id="template-wrapper">

					{{Render::layoutPreview($header_selected, $layout_selected, $footer_selected)}}
					
				</div>

			</li>

			<li>
				
				<header>

					<h2>{{t('heading.element.bar_title')}}</h2>

					<button id="create-element" class="btn btn-primary loading">
						<i class="fa fa-plus-circle"></i> {{t('form.button.element')}}
					</button>

				</header>

				<div class="dl">

					<form action="{{route('api.element.settings.valid')}}">

						<ol class="dl-list valid">

							{{Load::elementList($page_id, $element_id)}}

						</ol>

					</form>

				</div>

			</li>

		</ul>

	</div>

	<footer>
			
		<ul class="toolbar">
			<li class="active"><a href="#"><i class="fa fa-desktop"></i></a></li>
			<li><a href="#"><i class="fa fa-sort-amount-asc"></i></a></li>
		</ul>

	</footer>

</div>