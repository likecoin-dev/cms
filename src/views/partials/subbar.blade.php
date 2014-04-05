<div class="row">
	<div class="subbar">

		<div class="box">

			<h2>
				<span data-bind="text: pageName">{{$name}}</span>
			</h2>

		</div>

		<button type="button" class="subbar-toggle options-toggle">
			<i class="fa fa-cogs"></i>
		</button>

		<button type="button" class="subbar-toggle element-toggle">			
			@if($n_elements > 0)
			<span class="label label-primary">{{$n_elements}}</span>
			@endif
			<i class="fa fa-sort-amount-asc"></i>
		</button>

	</div>
</div>