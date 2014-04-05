@if(empty($apis))

	<span>{{t('marker._api.none')}}</span>

@else

	@foreach($apis as $value => $param)

		<span>
			<strong>{{$value}}:</strong> {{t('marker._api.' . $param[0])}} <em>({{$param[1]}})</em> <small><em>{{Marker::isMandatory($param[2])}}</em></small>
		</span>

	@endforeach

@endif