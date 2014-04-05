{{-- */ $day = $date->day; /* --}}
{{-- */ $month = $date->month; /* --}}
{{-- */ $year = $date->year; /* --}}
{{-- */ $hh = $date->hour; /* --}}
{{-- */ $mm = $date->minute; /* --}}

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
	<span>{{t('datetime.label.at')}}</span>
	<div class="form-group">
		{{Form::select($hh_name, $hours, null, array('class' => 'form-control', 'id' => $hh_name))}}
	</div>
	<span>:</span>
	<div class="form-group">
		{{Form::select($mm_name, $minutes, null, array('class' => 'form-control', 'id' => $mm_name))}}
	</div>
</div>