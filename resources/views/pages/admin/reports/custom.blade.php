@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li>Reports</li>
		  <li class="active">Ticket Reports</li>
		</ol>
	</div><!--row-->

	<div class="row form-header">
		<div class="col-md-12">
			<div class="form-header-inner">
				<h3>Ticket Reports</h3>
				<div class="search-btn input-group">
					<input type="text" id="filter" class="form-control search-control" placeholder="Search for...">
						<span class="input-group-btn">
						<button class="btn btn-default search-btn" type="button"><img  src="{{ asset('assets/images/search-icon.png') }}"/></button>
					</span>
				</div><!-- /input-group -->
		 	</div>
	 	</div>
	</div><!--row-->

	@include('includes.error')
	@include('includes.success')

	<div class="col-md-12">	
		<table border="1" cellpadding="0" cellspacing="0" id="example" class="table table-hover tableView admin-table" style="width: 70%;">
			<thead>
			<tr>
				<th><h4 style=" margin: 0;">Reports Name</h4></th>
				<th></th>
			</tr>
			</thead>
			<tbody class="searchable">
				<tr>
					<td><strong>Total Seat Booking by day</strong></td>
					<td class="alignCenter">@if(in_array('totalSeatBookingByDay', getRoutePath()))<a class="edit_btn" href="{{ url('totalSeatBookingByDay') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Current Seat Booking by day</strong></td>
					<td class="alignCenter">@if(in_array('currentSeatBookingByDay', getRoutePath()))<a class="edit_btn" href="{{ url('currentSeatBookingByDay') }}">View</a>@endif</td>
				</tr>
				
				<tr>
					<td><strong>Advance Booking by day</strong></td>
					<td class="alignCenter">@if(in_array('advanceBookingByDay', getRoutePath()))<a class="edit_btn" href="{{ url('advanceBookingByDay') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Ticket sales by movie</strong></td>
					<td class="alignCenter">@if(in_array('ticketSalesByMovie', getRoutePath()))<a class="edit_btn" href="{{ url('ticketSalesByMovie') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Number of Ticket sales by movie</strong></td>
					<td class="alignCenter">@if(in_array('numberOfTicketSalesByMovie', getRoutePath()))<a class="edit_btn" href="{{ url('numberOfTicketSalesByMovie') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Advance Ticket sales by movie</strong></td>
					<td class="alignCenter">@if(in_array('advanceTicketSalesByMovie', getRoutePath()))<a class="edit_btn" href="{{ url('advanceTicketSalesByMovie') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Number of Advance Ticket sales by movie</strong></td>
					<td class="alignCenter">@if(in_array('numberOfAdvanceTicketSalesByMovie', getRoutePath()))<a class="edit_btn" href="{{ url('numberOfAdvanceTicketSalesByMovie') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Cash in hand by day</strong></td>
					<td class="alignCenter">@if(in_array('cashInHandByDay', getRoutePath()))<a class="edit_btn" href="{{ url('cashInHandByDay') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Cash in hand by User</strong></td>
					<td class="alignCenter">@if(in_array('cashInHandByUser', getRoutePath()))<a class="edit_btn" href="{{ url('cashInHandByUser') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Ticket Cancellation by Day</strong></td>
					<td class="alignCenter">@if(in_array('ticketCancellationByDay', getRoutePath()))<a class="edit_btn" href="{{ url('ticketCancellationByDay') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Deals Report</strong></td>
					<td class="alignCenter">@if(in_array('dealReport', getRoutePath()))<a class="edit_btn" href="{{ url('dealReport') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Ticket Sales by User</strong></td>
					<td class="alignCenter">@if(in_array('ticketSalesByUser', getRoutePath()))<a class="edit_btn" href="{{ url('ticketSalesByUser') }}">View</a>@endif</td>
				</tr>
			</tbody>
		</table>
	</div>
</div><!-- container -->
<br><br>

@endsection