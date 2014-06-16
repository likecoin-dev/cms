@if(is_array($sections))

	@foreach($sections as $key => $section)

		@if( ! array_key_exists('hidden', $section))

			@if(array_key_exists('route', $section) or array_key_exists('class', $section))

				@if(array_key_exists('route', $section))
				
				<li>
					{{ link_to_route($section['route'], t('menu.' . $key)) }}
				</li>
				
				@endif
			
			@else
				
				<li class="dropdown">

					@if( ! empty($section))

					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						{{ t('menu.' . $key) }}
						<b class="caret"></b>
					</a>
					
					<ul class="dropdown-menu">

						{{ Render::sectionMenu($section) }}

					</ul>

					@endif

				</li>

			@endif
		
		@endif

	@endforeach

@endif