@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li>Reports</li>
		  <li class="active">Concession Reports</li>
		</ol>
	</div><!--row-->

	<div class="row form-header">
		<div class="col-md-12">
			<div class="form-header-inner">
				<h3>Concession Reports</h3>
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
					<td><strong>Item Sales</strong></td>
					<td class="alignCenter">@if(in_array('itemSales', getRoutePath()))<a class="edit_btn" href="{{ url('itemSales') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Single Item Sales</strong></td>
					<td class="alignCenter">@if(in_array('singleItemSales', getRoutePath()))<a class="edit_btn" href="{{ url('singleItemSales') }}">View</a>@endif</td>
				</tr>
				
				<tr>
					<td><strong>Item Sales by User</strong></td>
					<td class="alignCenter">@if(in_array('singleItemSalesByUser', getRoutePath()))<a class="edit_btn" href="{{ url('singleItemSalesByUser') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Package Sales</strong></td>
					<td class="alignCenter">@if(in_array('packageSales', getRoutePath()))<a class="edit_btn" href="{{ url('packageSales') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Single Package Sales</strong></td>
					<td class="alignCenter">@if(in_array('singlePackageSales', getRoutePath()))<a class="edit_btn" href="{{ url('singlePackageSales') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Package Sales by User</strong></td>
					<td class="alignCenter">@if(in_array('packageSalesByUser', getRoutePath()))<a class="edit_btn" href="{{ url('packageSalesByUser') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Concession Cancellation by Day</strong></td>
					<td class="alignCenter">@if(in_array('concessionCancellationByDay', getRoutePath()))<a class="edit_btn" href="{{ url('concessionCancellationByDay') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Concession Sale by all User</strong></td>
					<td class="alignCenter">@if(in_array('concessionSaleByAllUser', getRoutePath()))<a class="edit_btn" href="{{ url('concessionSaleByAllUser') }}">View</a>@endif</td>
				</tr>
			</tbody>
		</table>
	</div>
</div><!-- container -->
<br><Br>
@endsection