@extends('layouts.t_master')
@section('content')


<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		   <li><a href="{{url('/')}}">Home</a></li>
		  <li ><a href="{{url('/viewReserve')}}">View Bookings</a></li>
		  <li class="active">Confirm Booking</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm" id="mainform" action="{{route('viewReserve.store')}}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Booking Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="reset" class="btn submitBtn cancel-button">Cancel</button>
			 			@if($adv->status == 0)
				 			 @if(in_array('booking',getRoutePath()))<button type="submit" class="btn submitBtn save-button">Confirm Booking</button>@endif
				 		@endif
			 		</div>
			 	</div>
		 	</div>
	    </div><!--row-->
	
		@include('includes.error')
	  	@include('includes.success')

		<input type="hidden" name="adv_id" value="{{$adv->id}}">
		<div class="form-container">
			<div class="col-md-6">
				<div class="col-md-12">	
					<div class="form-group">
						<label for="name" class="col-sm-4 control-label">Customer Name: </label>
						<div class="col-sm-8">
							<input type="text" id="name" value="{{$adv->customerName}}" class="form-control" readonly>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="phone" class="col-sm-4 control-label">Customer Phone: </label>
						<div class="col-sm-8">
							<input type="text" id="phone" value="{{$adv->customerPhone}}" class="form-control" readonly>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="email" class="col-sm-4 control-label">Customer Email: </label>
						<div class="col-sm-8">
							<input type="text" id="email" value="{{$adv->customerEmail}}" class="form-control" readonly >
						</div>
					</div>
				</div>

				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="movie" class="col-sm-4 control-label"> Movie: </label>
						<div class="col-sm-8">
							<input type="text" id="movie" value="{{$adv->movies->title}}" class="form-control" readonly>
						</div>
					</div>
				</div>

		    	<div class="clear"></div>

		    	<div class="col-md-12">	
					<div class="form-group">
						<label for="showtime" class="col-sm-4 control-label">Show Time: </label>
						<div class="col-sm-8">
							<input type="text" id="showtime" value="{{ date('d-M-y H:i:s', strtotime($adv->show_times->dateTime))}}" class="form-control" readonly>
						</div>
					</div>
				</div>

		    	<div class="clear"></div>

		    	<div class="col-md-12">	
					<div class="form-group">
						<label for="seats_qty" class="col-sm-4 control-label">Seats qty: </label>
						<div class="col-sm-8">
							<input type="text" id="seats_qty" value="{{$adv->seatQty}}" class="form-control" readonly>
						</div>
					</div>
				</div>

		    	<div class="clear"></div>

		    	<div class="col-md-12">	
					<div class="form-group">
						<label for="seats_num" class="col-sm-4 control-label">Seats number: </label>
						<div class="col-sm-8">
							<textarea id="seats_id" class="form-control" style="height: 80px;"readonly>@for($i=0; $i<count(json_decode($adv->seatNumber)); $i++){{ json_decode($adv->seatNumber)[$i].', '}}@endfor</textarea>
						</div>
					</div>
				</div>

		    	<div class="clear"></div>

		    	<div class="col-md-12">	
					<div class="form-group">
						<label for="total_price" class="col-sm-4 control-label">Total Price: </label>
						<div class="col-sm-8">
							<input type="text" id="total_price" value="{{$adv->totalAmount}}" class="form-control" readonly>
						</div>
					</div>
				</div>

			</div><!-- col-md-6 -->

			<div class="col-md-offset-2 col-md-4">

				<div class="col-md-10">	
					<div class="form-group">
						<label for="item_status" class="col-sm-5 control-label"><span>* </span>Confirmed: </label>
						<div class="col-sm-7">
							<select class="status form-control">
								@if($adv->status == 1)
									<option value="1" @if($adv->status == 1) selected  @endif>Yes</option>
								@else
									<option value="1" @if($adv->status == 1) selected  @endif>Yes</option>
									<option value="0" @if($adv->status == 0) selected  @endif>No</option>
								@endif
							</select>
						</div>
					</div>
				</div>

		    	<div class="clear"></div>
		    	</div>

		 </div><!-- form-container -->
	  </form>

	<div class="delete_confirm_modal modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog modal-sm">
		    <div class="modal-content">
		      Confirm Delete?
		    </div>
		    <div class="modal-footer">
		    	<input type="hidden" class="id_to_delete" value="" />
		        <button type="button"  class="btn btn-default btn_yes" data-dismiss="modal" >Yes</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		    </div>
		 </div>
	</div><!-- Modal -->

</div><!-- Container Close -->
</div>

@endsection

@section('scripts')
	<script type="text/javascript">

		$(".modal-footer").on('click', '.btn_yes',function() {
			var id_to_delete = $('.id_to_delete').val();
			//console.log(id_to_delete);
			// $.post(baseUrl+'ajax.php', {'to_delete': id_to_delete, 'action': 'del_record'}, function(data) {
					
			// 		console.log(data);
			// 		$("#mainform").find("input[type=text], textarea").val("");
			// });
		});
	</script>	
@endsection


