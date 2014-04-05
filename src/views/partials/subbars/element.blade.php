
	<div class="subbar">

		<div class="box">

			<h2><em>{{strtoupper(LANG)}}</em> {{$page_link}} <span data-bind="text: itemName">{{$name}}</span></h2>

		</div>

		<button type="button" class="subbar-toggle options-toggle">
			<i class="fa fa-cogs"></i>
		</button>

		<button type="button" class="subbar-toggle right-toggle element-toggle">			
			@if($n_elements > 0)
			<span class="label label-primary counter">{{$n_elements}}</span>
			@endif
			<i class="fa fa-sort-amount-asc"></i>
		</button>

	</div>
