@foreach($ticketSales as $ticket)
	@if(todayTicket($ticket)>0)
	<div class="col-md-12 col-sm-12 daily-states-row  nopadding">
		<div class="col-md-3 col-xs-3 daily-states-data">{{todayTicket($ticket)}}</div>
		<div class="col-md-5 col-xs-5 daily-states-data"><span>{{$ticket->firstName}}</span></div>
		<div class="col-md-4 col-xs-4 daily-states-data"><span>{{count($ticket->bookings)}}</span></div>
	</div>
	@endif
	<!-- daily-states-data-->
@endforeach