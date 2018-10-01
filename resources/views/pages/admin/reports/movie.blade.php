@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li>Reports</li>
		  <li class="active">Movie Reports</li>
		</ol>
	</div><!--row-->

	<div class="row form-header">
		<div class="col-md-12">
			<div class="form-header-inner">
				<h3>Movie Reports</h3>
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
					<td><strong>Films By Distributor</strong></td>
					<td class="alignCenter">@if(in_array('filmsByDistributor', getRoutePath()))<a class="edit_btn" href="{{ url('filmsByDistributor') }}">View</a>@endif</td>
				</tr>

				<tr>
					<td><strong>Shows by Time</strong></td>
					<td class="alignCenter">@if(in_array('showsByTime', getRoutePath()))<a class="edit_btn" href="{{ url('showsByTime') }}">View</a>@endif</td>
				</tr>
				
				<tr>
					<td><strong>Weekly Movie Report</strong></td>
					<td class="alignCenter">@if(in_array('weeklyMovieReport', getRoutePath()))<a class="edit_btn" href="{{ url('weeklyMovieReport') }}">View</a>@endif</td>
				</tr>

			</tbody>
		</table>
	</div>
</div><!-- container -->

@endsection