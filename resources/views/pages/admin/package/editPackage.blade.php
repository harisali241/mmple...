@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('/package') }}">Package</a></li>
		  <li class="active">Update Package</li>
		</ol>
	</div><!--row-->
	{!! Form::model($package , ['method' => 'PATCH','url' => ['package', $package->id], 'files' => true, 'class' => 'form-horizontal dashboardForm']) !!}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Package Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Save Package</button>
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
								{!! Form::text('name' , null ,['id' => 'package_name' ,'class' => 'form-control', 'required' => 'required']) !!}
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="package_name" class="col-sm-4 control-label"><span>* </span>Package desc: </label>
							<div class="col-sm-8">
								{!! Form::text('description' , null ,['id' => 'package_desc' ,'class' => 'form-control', 'required' => 'required']) !!}
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="package_measuring_unit" class="col-sm-4 control-label"><span>* </span> Measuring Unit	: </label>
							<div class="col-sm-8">
								{!! Form::select('measuringUnit', measuringUnit(), null,['class' => 'form-control', 'required' => 'required']) !!}
							</div>
						</div>
					</div>

					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="package_category" class="col-sm-4 control-label">Category: </label>
							<div class="col-sm-8">
								{!! Form::select('foodCategory_id',$foodCategories, null,['class' => 'form-control', 'required' => 'required']) !!}
								{{-- <select name="foodCategory_id" class="form-control">
								<option value="" selected disabled>select</option>
								@foreach($foodCategories as $food)
									<option value="{{ $food->id }}">{{ $food->name }}</option>
								@endforeach
								</select> --}}
							</div>
						</div>
					</div>
					
					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="package_price" class="col-sm-4 control-label"><span> * </span> Default Price: </label>
							<div class="col-sm-8">
								{!! Form::text('defaultPrice' , null ,['id' => 'package_price' ,'class' => 'form-control', 'required' => 'required' , 'readonly' => 'readonly']) !!}
							</div>
						</div>
					</div>
					
					<div class="clear"></div>

					<div class="col-md-12">	
						<div class="form-group">
							<label for="package_cost_price" class="col-sm-4 control-label"><span>* </span> Cost Price: </label>
							<div class="col-sm-8">
								{!! Form::text('costPrice' , null ,['id' => 'package_cost_price' ,'class' => 'form-control', 'required' => 'required']) !!}
							</div>
						</div>
					</div>
			    	<div class="clear"></div>

			    	<div class="col-md-12">	
						<div class="form-group">
							<label for="item_img" class="col-sm-4 control-label">Display Order #: </label>
							<div class="col-sm-8">
								{!! Form::number('displayOrder' , null ,['id' => 'package_order_no' ,'class' => 'form-control']) !!}
							</div>
						</div>
					</div>

			    	<div class="clear"></div>

			    	<div class="col-md-12">	
						<div class="form-group">
							<label for="item_img" class="col-sm-4 control-label">Package bg: </label>
							<div class="col-sm-8">
								<select class="form-control" name="bgColor" id="package_bg" style="background-color:{{$package->bgColor}};" required>
									<option value="" selected disabled>Select below</option>
									@foreach(bgColor() as $color)
										<option value="{{ $color }}" style="background-color:{{ $color }};" @if($package->bgColor == $color) {{'selected = "selected"'}} @endif></option>
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
								{!! Form::select('status',[ '0' => 'Inactive' ,'1' => 'Active', '2' => 'Planned' ], null,['class' => 'form-control status']) !!}
							</div>
						</div>
					</div>

			    	<div class="clear"></div>

					<div class="col-md-12 item_img">
						@if($package->image != '')
							<div class="profilePic">
					           <span>
					            <img src="{{ asset('assets/images/uploads/m_'.$package->image) }}" class="img-responsive" alt="">
					            <a id="removeProfilePic"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
					           </span>
					        </div>

					        <div class="form-group" id="showNewPicSubmit" style="display:none;">
								<label for="movie_synopsis" class="col-sm-2 control-label">Image: </label>
								<div class="col-sm-10">
									{!! Form::file('image' , null ,['class' => 'form-control', 'style' => 'width:100%;height: 33px;']) !!}
								</div>
							</div>
						@else
					        <div class="form-group">
								<label for="movie_synopsis" class="col-sm-2 control-label">Image: </label>
								<div class="col-sm-10">
									{!! Form::file('image' , null ,['class' => 'form-control', 'style' => 'width:100%;height: 33px;']) !!}
								</div>
							 </div>
						@endif
				         
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
							@php
								$itemName = json_decode($package->itemName);
								$itemPrice = json_decode($package->itemPrice);
								$itemQty = json_decode($package->itemQty);
							@endphp
							@for($i=0; $i < count($itemName); $i++)
								<div class="col-md-12 row-el row{{$i}}">
									<div class="col-md-3">
										<div class="item-group">
											<select name="itemName[]" id="item{{$i}}" class="package_item_name form-control" required>
												<option value="" selected disabled>select item</option>
												@foreach($items as $item)
													<option value="{{ $item->name }}" @if($item->name == $itemName[$i]) {{ 'selected="selected"' }} @endif>{{$item->name}}</option>
												@endforeach
											</select>
									  	</div>
									</div>
									<div class="col-md-3">
										<div class="item-group">
											<input type="text" name="itemPrice[]" class="form-control itemprice item{{$i}}price"  placeholder="0" class="form-control" value="{{ $itemPrice[$i] }}" readonly required>
										</div>
									</div>
									<div class="col-md-3">
										<div class="item-group">
											<input type="text" name="itemQty[]" onkeyup="qty();" class="form-control itemqty item{{$i}}qty"   placeholder="0" class="form-control" value="{{ $itemQty[$i] }}" required>
										</div>
									</div>
									<div class="col-md-2 col-md-offset-1 txt-center">
										<button type="button" class="btn submitBtn minus-btn" onclick="deleteRow({{$i}})" value="" >Remove x</button>
									</div>
								</div>
							@endfor
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

		function deleteRow(i){
			$('.row'+i).remove();
			update_amounts();
		}

			
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