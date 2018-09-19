@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('/package') }}">Package</a></li>
		  <li class="active">Add Package</li>
		</ol>
	</div><!--row-->
	<form class="form-horizontal dashboardForm"  action="{{ route('package.store') }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Package Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Add Package</button>
			 		</div>
			 	</div>
		 	</div>
	  	</div><!--row-->

	  	@include('includes.error')
		@include('includes.success')
			
		<div class="row">
			<div class="form-container">
				<div class="col-md-6">

					<div class="col-md-12">	
						<div class="form-group">
							<label for="package_name" class="col-sm-4 control-label"><span>* </span>Package Name: </label>
							<div class="col-sm-8">
								<input type="text" name="name" id="package_name" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="package_name" class="col-sm-4 control-label"><span>* </span>Package desc: </label>
							<div class="col-sm-8">
								<input type="text" name="description" id="package_desc" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="package_measuring_unit" class="col-sm-4 control-label"><span>* </span> Measuring Unit	: </label>
							<div class="col-sm-8">
								<select name="measuringUnit" class="form-control" required>
									<option value="" selected disabled>select</option>
									@foreach(measuringUnit() as $unit)
										<option value="{{ $unit }}">{{ $unit }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="package_category" class="col-sm-4 control-label">Category: </label>
							<div class="col-sm-8">
								<select name="foodCategory_id" class="form-control">
								<option value="" selected disabled>select</option>
								@foreach($foodCategories as $food)
									<option value="{{ $food->id }}">{{ $food->name }}</option>
								@endforeach
								</select>
							</div>
						</div>
					</div>
					
					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="package_price" class="col-sm-4 control-label"><span> * </span> Default Price: </label>
							<div class="col-sm-8">
								<input type="text" name="defaultPrice" id="package_price" class="form-control" readonly="" required>
							</div>
						</div>
					</div>
					
					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="package_cost_price" class="col-sm-4 control-label"><span>* </span> Cost Price: </label>
							<div class="col-sm-8">
								<input type="text" name="costPrice" id="package_cost_price" class="form-control" required>
							</div>
						</div>
					</div>
			    	<div class="clear"></div>

			    	<div class="col-md-12">	
						<div class="form-group">
							<label for="item_img" class="col-sm-4 control-label">Display Order #: </label>
							<div class="col-sm-8">
								<input type="number" name="displayOrder" id="package_order_no" class="form-control" >
							</div>
						</div>
					</div>

			    	<div class="clear"></div>

			    	<div class="col-md-12">	
						<div class="form-group">
							<label for="item_img" class="col-sm-4 control-label">Package bg: </label>
							<div class="col-sm-8">
								<select class="form-control" name="bgColor" id="item_bg" style="background-color:;" required>
									<option value="" selected disabled>Select below</option>
									@foreach(bgColor() as $color)
										<option value="{{ $color }}" style="background-color:{{ $color }};"></option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

			    	<div class="clear"></div>
					    	
				</div><!-- col-md-6 -->

				<div class="col-md-offset-2 col-md-4">

					<div class="col-md-8">	
						<div class="form-group">
							<label for="package_status" class="col-sm-4 control-label">Status: </label>
							<div class="col-sm-8">
								<select class="form-control status" name="status" required>
									<option value="1">Acive</option>
									<option value="2">Planned</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>
					</div>

			    	<div class="clear"></div>

					<div class="col-md-12 item_img">
				         <div class="form-group">
							<label for="movie_synopsis" class="col-sm-2 control-label">Image: </label>
							<div class="col-sm-10">
								 <input type="hidden" class="form-control" name="image" id="photo" readonly>
								 <input type="file" name="image" class="form-control" style="width:100%;height: 33px;">
							</div>
						 </div>
					</div>
				</div><!-- col-md-6 -->


				<div class="col-md-12 bottom-label">
					<div class="col-md-6">
						<h3>Package Items.</h3>
							<span>Add or remove items and their details for this package</span>
						</div>

					<div class="col-md-6 form-header-right">
						<button type="button" class="btn submitBtn save-button person_btn" value="" onclick="additem()">Add Item</button>
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
					<div id="itemcontainer">
						<div class="row">

						</div>
					</div><!-- #Content CLose -->
				</div><!-- col-md-12 -->	
			</div><!--form-container -->
		</div><!--row -->
	</form>
	
@endsection
	
@section('scripts')
	
	<script>
		//console.log('ok');
		function update_amounts()
		{
		    var sum = 0.0;
		    $('#itemcontainer .row-el').each(function() {
		        var qty = $(this).find('.itemprice').val();
		        var price = $(this).find('.itemqty').val();
		        var amount = (qty*price)
		        sum+=amount;
		        $(this).find('.amount').text(''+amount);
		    });
		    // update the total to sum  
		   // console.log(sum);
		    $('#package_price').val(sum);
		}
		
		function qty(){
			update_amounts();
		}

		function additem(){

			var len = $('.row-el').length;
			//console.log(len);
			var div = document.createElement('div');
			div.className = 'row';
			div.innerHTML = '<div class="col-md-12 row-el">\
									<div class="col-md-3">\
										<div class="item-group">\
										 <select name="itemName[]" id="item'+len+'" class="package_item_name form-control" required>\
												<option value="" selected disabled>select item</option>\
												@foreach($items as $item)\
													<option value="{{ $item->name }}">{{$item->name}}</option>\
												@endforeach\
											</select>\
										  </div>\
										</div>\
										<div class="col-md-3">\
											<div class="item-group">\
												<input type="text" name="itemPrice[]" class="form-control itemprice item'+len+'price"  placeholder="0" class="form-control" readonly required>\
											</div>\
										</div>\
										<div class="col-md-3">\
											<div class="item-group">\
												<input type="text" name="itemQty[]" onkeyup="qty();" class="form-control itemqty"   placeholder="0" class="form-control" required>\
											</div>\
										 </div>\
										<div class="col-md-2 col-md-offset-1 txt-center">\
											<button type="button" class="btn submitBtn minus-btn" value="" >Remove x</button>\
										</div>\
									</div>\
								</div>';
			 document.getElementById('itemcontainer').appendChild(div);
		}

		$("#itemcontainer").on('click', '.minus-btn', function() {
			$(this).parents('.row-el').parent('.row').remove();
			update_amounts();
		});

			
		$(document).ready(function(){
			update_amounts();

			function qty(){
				update_amounts();
			}

			// set price on item change
			$("#itemcontainer").on('change', '.package_item_name', function(event) {
			    event.preventDefault();
			    var control_id = $(this).attr('id');
			    var itemName = $('#'+control_id).val();

			    $.ajax({
                    url: '/getItemPrice',
                    method:'POST',
                    dataType:'json',
                    data:{ 'itemName' : itemName , '_token': '{{csrf_token()}}' },
                    success: function (data) {
                    	console.log(data);
				        $('.'+control_id+'price').val(data);
				        update_amounts();
                    },
                });

			   // $.post('ajax.php', {'getitem': getitem, 'action': 'get_item_detail'}, function(data) {
			   // 		//console.log(data);
			   //      console.log(control_id);
			   //     $('.'+control_id+'price').val(data.item_default_price);
			   //     update_amounts();

			   // });
	   		});//end 

			//update amount on quantity change
	   		$("#itemcontainer").on("change", ".itemqty", function(event) {
	  			update_amounts();
	   		 });
	 	});
	</script>	

@endsection