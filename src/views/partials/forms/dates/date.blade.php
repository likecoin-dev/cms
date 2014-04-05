{{-- */ $day = $date->day; /* --}}
{{-- */ $month = $date->month; /* --}}
{{-- */ $year = $date->year; /* --}}

<div class="form-inline">
	<div class="form-group">
		{{Form::select($day_name, array_combine(range(1,31), range(1,31)), null, array('class' => 'form-control', 'id' => $day_name))}}
	</div>
	<div class="form-group">
		{{Form::select($month_name, $months, null, array('class' => 'form-control', 'id' => $month_name))}}
	</div>
	<div class="form-group">
		{{Form::select($year_name, array_combine(range($year,$year-$year_past), range($year,$year-$year_past)), null, array('class' => 'form-control', 'id' => $year_name))}}
	</div>
</div>