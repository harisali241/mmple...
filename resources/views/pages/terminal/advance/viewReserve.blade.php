@extends('layouts.t_master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('advBooking')}}">Home</a></li>
		  <li class="active">View Bookings</li>
		</ol>
	</div><!--row-->

	<div class="row form-header">
		<div class="col-md-12">
			<div class="form-header-inner">
				<h3>View Bookings</h3>
				<div class="search-btn input-group">
					<input type="text" id="filter" class="form-control search-control" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default search-btn" type="button"><img  src="{{asset('assets/images/search-icon.png')}}"/></button>
					</span>
				</div><!-- /input-group -->
		 	</div>
	 	</div>
	</div><!--row-->

		@include('includes.error')
	  	@include('includes.success')

	<div class="row">
		<div class="col-md-12">
			<div class="form-header-inner">
				 @if(in_array('advBooking',getRoutePath()))<a class="pull-right add-button" href="{{url('advBooking')}}">Add Advance Bookings </a>@endif
			</div>
		</div><!--col-md-12-->
	</div><!--row-->

	<div class="row">
		<div class="col-md-12">	
			@if(count($advs) > 0)
				<table border="1" cellpadding="0" cellspacing="0" id="example" class="table table-hover tableView admin-table" style="font-size:14px;">
					<thead>
						<tr>
							<th>Customer Name</th>
							<th>Phone Number</th>
							<th>Movie</th>
							<th>Showtime</th>
							<th>Booking Date</th>
							<th>Confirmed</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody class="searchable">
						@foreach($advs as $adv)
						<tr>
							<td>{{ $adv->customerName }}</td>
							<td>{{ $adv->customerPhone }}</td>
							<td>{{ $adv->movies->title}}</td>
							<td>{{ date('d-M-y H:i:s', strtotime($adv->show_times->dateTime))}}</td>
							<td>{{ date('d-M-y', strtotime($adv->create_at))}}</td>
							<td>
								@if($adv->status == 1)
									<p>Confrim</p>
								@else
									<p>Not Confrim</p>
								@endif
							</td>
							<td class="alignCenter"><a class="edit_btn" href="{{ url('viewReserve/'.$adv->id.'/edit') }}">Details</a></td>
							
							<td class="alignCenter">
								@if($adv->status == 0)
								<form action="{{ url('viewReserve/'.$adv->id) }}" method="post" id="delete{{$adv->id}}">
			                   		{{ csrf_field() }}
			                   		{{method_field("DELETE")}}
									<input type="hidden" class="id_to_delete" value="{{ $adv->id }}"><a style="cursor:pointer;" data-toggle="modal" data-target=".delete_confirm_modal"><img class="img_delete" src="{{ asset('assets/images/delete_icon.png') }}"/></a>
								</form>	
								@endif
							</td>
						
						</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<p align="center">
					No Record
				</p>
			@endif
		</div>
	</div><!-- Row Close -->

		<div class="delete_confirm_modal modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		 	<div class="modal-dialog modal-sm">
			    <div class="modal-content">
			      Confirm Delete?
			    </div>
			    <div class="modal-footer">
			     	
			        <button type="button"  class="btn btn-default btn_yes" data-dismiss="modal" >Yes</button>
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			 
			    </div>
		  	</div>
		</div><!-- Modal -->

</div><!-- Container Close -->
<br><br>
</div>

<script type="text/javascript">
		var id_to_delete;

		$(".container").on('click', '.img_delete',function() {
			id_to_delete = $(this).parent().parent().find('.id_to_delete').val();
		});

			$(".modal-footer").on('click', '.btn_yes',function() {
				console.log(id_to_delete);
				$("#delete"+id_to_delete).submit();
			});
	</script>


@endsection