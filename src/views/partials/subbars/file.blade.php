
	<div class="subbar">

		<div class="box">

			<h2><em>{{strtoupper(LANG)}}</em> {{$page_link}} <span data-bind="text: itemName">{{$name}}</span></h2>

		</div>

		<button type="button" class="subbar-toggle options-toggle">
			<i class="fa fa-cogs"></i>
		</button>

		<button type="button" class="subbar-toggle right-toggle file-toggle">
			@if($n_files > 0)
			<span class="label label-primary counter">{{$n_files}}</span>
			@endif
			<i class="fa fa-picture-o"></i>
		</button>

	</div>
