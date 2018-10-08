@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('voucher') }}">Vouchers</a></li>
		  <li class="active">Update Voucher</li>
		</ol>
	</div><!--row-->

	{!! Form::model($voucher , ['method' => 'PATCH','url' => ['voucher', $voucher->id], 'files'=>true, 'class' => 'form-horizontal dashboardForm']) !!}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Voucher Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button" >Save Change</button>
			 		</div>
			 	</div>
		 	</div>
		</div><!--row-->

		@include('includes.error')
		@include('includes.success')

		<div class="row">
			<div class="form-container" id="voucher_container">	
				<div class="col-md-6">
		
					<div class="clear"></div>
					<div class="col-md-12">	
						<div class="form-group">
							<label for="itemname" class="col-sm-4 control-label"><span>*</span> Voucher Name: </label>
							<div class="col-sm-8">
								{!! Form::text('title' , null ,['id' => 'voucher_title' ,'class' => 'form-control', 'required' => 'required']) !!}
							</div>
						</div>
					</div>
					<div class="clear"></div>
					
					
					<div class="col-md-12">	
						<div class="form-group">
							<label for="voucher_price" class="col-sm-4 control-label"><span>*</span> Voucher Price: </label>
							<div class="col-sm-8">
								{!! Form::text('price' , null ,['id' => 'voucher_price' ,'class' => 'form-control', 'required' => 'required']) !!}
							</div>
						</div>
					</div>
					
					<div class="clear"></div>


					<div class="col-md-12">	
						<div class="form-group">
							<label for="voucher_startdate" class="col-sm-4 control-label"><span>*</span> Start Date: </label>
							<div class="col-sm-8">
								{!! Form::text('startDate' , null ,['id' => 'date_timepicker_start' ,'class' => 'form-control datetimepicker', 'required' => 'required']) !!}
							</div>
							
						</div>
					</div>

					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="voucher_enddate" class="col-sm-4 control-label"><span>*</span> Expire Date: </label>
							<div class="col-sm-8">
								{!! Form::text('endDate' , null ,['id' => 'date_timepicker_end' ,'class' => 'form-control datetimepicker', 'required' => 'required']) !!}
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">	
						<div class="form-group">
							<label for="voucher_is_package" class="col-sm-4 control-label">Is Package: </label>
							<div class="col-sm-8">
								{!! Form::select('isPackage',[ '1' => 'Yes' ,'0' => 'No' ], null,['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="voucher_desc" class="col-sm-4 control-label">Description: </label>
							<div class="col-sm-8">
								{!! Form::text('description' , null ,['id' => 'voucher_desc' ,'class' => 'form-control']) !!}
							</div>
						</div>
					</div>

					<div class="clear"></div>
				</div><!-- col-md-6 -->

				<div class="col-md-offset-3 col-md-3">

					<div class="col-md-12">	
						<div class="form-group">
							<label for="itemname" class=" col-sm-4 control-label"><span>*</span>Status: </label>
							<div class="col-sm-8">
								{!! Form::select('status',[ '0' => 'Inactive' ,'1' => 'Active', '2' => 'Planned' ], null,['class' => 'form-control status']) !!}
							</div>
						</div>
					</div>

				</div><!-- col-md-6 -->

				<div class="col-md-12 bottom-label">
					<div class="col-md-6">
						<h3>Items</h3>
							<span>Add or remove items and their details for this voucher</span>
						</div>

					<div class="col-md-6 form-header-right">
						<button type="button" class="person_btn btn submitBtn save-button" value="" onclick="addvoucher_item()">Add Item</button>
					</div>
				</div>

				<div class="col-md-12 label-container">
					<div class="col-md-3">
						Item Name
					</div>

					<div class="col-md-3">
						Item Price
					</div>

					<div class="col-md-3">
						Item Quantity
					</div>

					<div class="col-md-3">
					</div>
				</div><!-- col-md-12 -->

				<div class="col-md-12 ">
					<div id="voucheritemcontainer">
						<div class="row">
							
							@php
								$itemName = json_decode($voucher->itemName);
								$itemPrice = json_decode($voucher->itemPrice);
								$itemQty = json_decode($voucher->itemQty);
							@endphp
							@for($i=0; $i < count($itemName); $i++)
								
								<div class="col-md-12 row-el rowItem{{$i}}">
									<div class="col-md-3">
										<div class="item-group">
										 	<select name="itemName[]" id="voucher_item{{$i}}" class="voucher_package_item_name form-control" required>
												<option value="" selected disabled>select item</option>
												@foreach($items as $item)
													<option value="{{ $item->name }}" @if($item->name == $itemName[$i]) {{ 'selected="selected"' }} @endif>{{ $item->name }}</option>
												@endforeach
											</select>
										 </div>
									</div>
									<div class="col-md-3">
										<div class="item-group">
											<input type="text" name="itemPrice[]" class="form-control voucher_itemprice voucher_item{{$i}}price" value="{{ $itemPrice[$i] }}" placeholder="0" class="form-control" readonly required>
										</div>
									</div>
									<div class="col-md-3">
										<div class="item-group">
											<input type="text" name="itemQty[]" class="form-control voucher_itemqty voucher_item{{$i}}qty" onkeyup="voucherAmount()" placeholder="0" class="form-control" value="{{ $itemQty[$i] }}" required>
										</div>
									</div>
									<div class="col-md-2 col-md-offset-1 txt-center">
										<button type="button" class="btn submitBtn minus-btn" value="" onclick="deleteRow('Item'+{{$i}})" >Remove x</button>
									</div>
								</div>

							@endfor

						</div><!-- row -->
					</div><!-- #Content CLose -->
				</div><!-- col-md-12 -->	

				<div class="col-md-12 bottom-label">
					<div class="col-md-6">
						<h3>Tickets</h3>
							<span>Add or remove tickets and their details for this voucher type</span>
						</div>

					<div class="col-md-6 form-header-right">
						<button type="button" class="person_btn btn submitBtn save-button" value="" onclick="addvoucher_ticket()">Add Ticket</button>
					</div>
				</div>

				<div class="col-md-12 label-container">
					<div class="col-md-3">
						Ticket Name
					</div>

					<div class="col-md-3">
						Ticket Price
					</div>

					<div class="col-md-3">
						Ticket Quantity
					</div>

					<div class="col-md-3">
					</div>
				</div><!-- col-md-12 -->

				<div class="col-md-12 ">
					<div id="voucher_ticketcontainer">
						<div class="row">

							@php
								$ticketName = json_decode($voucher->ticketName);
								$ticketPrice = json_decode($voucher->ticketPrice);
								$ticketQty = json_decode($voucher->ticketQty);
							@endphp
							@for($i=0; $i < count($ticketName); $i++)

								<div class="col-md-12 row-el rowTicket{{$i}}">
									<div class="col-md-3">
										<div class="item-group">
											<select name="ticketName[]" id="" class="voucher_package_ticket_name form-control" required>
												<option value="" selected disabled>select Ticket</option>
												@foreach($tickets as $ticket)
													 <option value="{{ $ticket->title }}" @if($ticket->title == $ticketName[$i]) {{ 'selected="selected"' }} @endif>{{ $ticket->title }}</option>
												@endforeach
											</select>
									 	</div>
									</div>
									<div class="col-md-3">
										<div class="item-group">
											<input type="text" name="ticketPrice[]" class="form-control voucher_itemprice voucher_item{{$i}}price" value="{{ $ticketPrice[$i] }}" placeholder="0" class="form-control" readonly required>
										</div>
									</div>
									<div class="col-md-3">
										<div class="item-group">
											<input type="text" name="ticketQty[]" class="form-control voucher_itemqty voucher_item{{$i}}qty" onkeyup="voucherAmount()" placeholder="0" class="form-control" required  value="{{ $ticketQty[$i] }}">
										</div>
									 </div>
									<div class="col-md-2 col-md-offset-1 txt-center">
										<button type="button" class="btn submitBtn minus-btn" value="" onclick="deleteRow('Ticket'+{{$i}})" >Remove x</button>
									</div>
								</div>

							@endfor

						</div><!-- row -->
					</div><!-- #Content CLose -->
				</div><!-- col-md-12 -->
			</div><!-- form-container -->	
		</div><!--row -->

	  </form>
	<div class="delete_confirm_modal modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      Confirm Delete?
	    </div>
	    <div class="modal-footer">
	        <button type="button" class="btn btn-default btn_yes" data-dismiss="modal">Yes</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	    </div>
	  </div>
	</div><!-- Modal -->	
@endsection

@section('scripts')
	<script type="text/javascript">
	
		function voucherAmount(){
			update_voucher_amounts();
		}
   		
   		function update_voucher_amounts()
		{
		    var sum = 0.0;
		    $('#voucher_container .row-el').each(function() {
		        var qty = $(this).find('.voucher_itemprice ').val();
		        var price = $(this).find('.voucher_itemqty').val();
		        var amount = (qty*price)
		        sum+=amount;
		        $(this).find('.amount').text(''+amount);
		    });
		    // update the total to sum  
		   // console.log(sum);
		    $('#voucher_price').val(sum);
		}//end


		function addvoucher_item() {
		var rowlen = $('.row-el').length;
		//console.log(len);
		var div = document.createElement('div');
		div.className = 'row';
		div.innerHTML = '<div class="col-md-12 row-el">\
							<div class="col-md-3">\
								<div class="item-group">\
								 	<select name="itemName[]" id="voucher_item'+rowlen+'" class="voucher_package_item_name form-control" required>\
										<option value="" selected disabled>select item</option>\
											@foreach($items as $item)\
												<option value="{{ $item->name }}">{{ $item->name }}</option>\
											@endforeach\
										</select>\
								 </div>\
							</div>\
							<div class="col-md-3">\
								<div class="item-group">\
									<input type="text" name="itemPrice[]" class="form-control voucher_itemprice voucher_item'+rowlen+'price"  placeholder="0" class="form-control" readonly required>\
								</div>\
							</div>\
							<div class="col-md-3">\
								<div class="item-group">\
									<input type="text" name="itemQty[]" class="form-control voucher_itemqty" onkeyup="voucherAmount()" placeholder="0" class="form-control" required>\
								</div>\
							</div>\
							<div class="col-md-2 col-md-offset-1 txt-center">\
								<button type="button" class="btn submitBtn minus-btn" value="" >Remove x</button>\
							</div>\
						</div>';
		 document.getElementById('voucheritemcontainer').appendChild(div);
		}

		function addvoucher_ticket() {
		var ticket_rowlen = $('.row-el').length;
		//console.log(len);
		var div = document.createElement('div');
		div.className = 'row';
		div.innerHTML = '<div class="col-md-12 row-el">\
							<div class="col-md-3">\
								<div class="item-group">\
									<select name="ticketName[]" id="voucher_ticket'+ticket_rowlen+'" class="voucher_package_ticket_name form-control" required>\
										<option value="" selected disabled>select item</option>\
										@foreach($tickets as $ticket)\
											 <option value="{{ $ticket->title }}">{{ $ticket->title }}</option>\
										@endforeach\
									</select>\
							 	</div>\
							</div>\
							<div class="col-md-3">\
								<div class="item-group">\
									<input type="text" name="ticketPrice[]" class="form-control voucher_itemprice voucher_ticket'+ticket_rowlen+'price"  placeholder="0" class="form-control" readonly required>\
								</div>\
							</div>\
							<div class="col-md-3">\
								<div class="item-group">\
									<input type="text" name="ticketQty[]" class="form-control voucher_itemqty" onkeyup="voucherAmount()" placeholder="0" class="form-control" required>\
								</div>\
							 </div>\
							<div class="col-md-2 col-md-offset-1 txt-center">\
								<button type="button" class="btn submitBtn minus-btn" value="" >Remove x</button>\
							</div>\
						</div>';
		 	document.getElementById('voucher_ticketcontainer').appendChild(div);
		}
		
		// Minus Button function for Offer Page
		$("#voucheritemcontainer").on('click', '.minus-btn', function() {
			$(this).parents('.row-el').parent('.row').remove();
			update_voucher_amounts();
		});

		// Minus Button function for Offer Page
		$("#voucher_ticketcontainer").on('click', '.minus-btn', function() {
			$(this).parents('.row-el').parent('.row').remove();
			update_voucher_amounts();
		});

		function deleteRow(i){
			$('.row'+i).remove();
			update_amounts();
		}

	$(document).ready(function(){
	
	// at ticket page set price on item change 
		$("#voucheritemcontainer").on('change', '.voucher_package_item_name', function(event) {
		    event.preventDefault();
		    var control_id = $(this).attr('id');
		    var itemName = $('#'+control_id).val();
		    console.log(control_id);
		  	$.ajax({
                url: baseUrl+'/getItemPrice',
                method:'POST',
                dataType:'json',
                data:{ 'itemName' : itemName , '_token': '{{csrf_token()}}' },
                success: function (data) {
                	//console.log(data);
			        $('.'+control_id+'price').val(data);
			        update_voucher_amounts();
                },
            });
		});//end 

   		$("#voucher_ticketcontainer").on('change', '.voucher_package_ticket_name', function(event) {
		    event.preventDefault();
		    var control_id = $(this).attr('id');
		    var ticketPrice = $('#'+control_id).val();

		   $.ajax({
                url: baseUrl+'/getTicketPrice',
                method:'POST',
                dataType:'json',
                data:{ 'ticketPrice' : ticketPrice , '_token': '{{csrf_token()}}' },
                success: function (data) {
                	//console.log(data);
			        $('.'+control_id+'price').val(data);
			        update_voucher_amounts();
                },
            });
   		});//end 

   		//update amount on quantity change
   		$("#voucher_container").on("change", ".voucher_itemqty", function(event) {
  			update_voucher_amounts();
   		 });
			

	}); //document ready


	</script>

@endsection