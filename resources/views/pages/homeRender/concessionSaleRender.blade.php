@foreach($concessionSales as $con)
	<!-- daily-states-dat-->
	@if(todayConsession($con)>0)
	<div class="col-md-12 col-sm-12 daily-states-row  nopadding">
		<div class="col-md-3 col-xs-3 daily-states-data">{{todayConsession($con)}}</div>
		<div class="col-md-5 col-xs-5 daily-states-data"><span>{{$con->firstName}}</span></div>
		<div class="col-md-4 col-xs-4 daily-states-data"><span>{{count($con->concession_details)}}</span></div>
	</div>
	@endif
	<!-- daily-states-data-->
@endforeach