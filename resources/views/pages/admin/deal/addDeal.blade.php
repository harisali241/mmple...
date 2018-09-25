@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('deal') }}">Deals</a></li>
		  <li class="active">Add Deal</li>
		</ol>
	</div><!--row-->
	<form class="form-horizontal dashboardForm"  action="{{ route('deal.store') }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Deal Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Add Deal</button>
			 		</div>
			 	</div>
		 	</div>
		</div><!--row-->

		@include('includes.error')
	  	@include('includes.success')

		<div class="row" >
			<div class="form-container" style="min-height: 500px;">

				<div class="col-md-6">

					<div class="col-md-12">
						<div class="form-group">
							<label for="deal_name" class="col-sm-4 control-label"><span>*</span> Deal Name: </label>
							<div class="col-sm-8">
								<input type="text" name="name" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="col-sm-4 control-label">Movie </label>
							<div class="col-sm-8">
								<select class="form-control moive_id" name="moive_id">
									<option value="" selected>All Movies</option>
									@foreach($movies as $movie)
										<option value="{{$movie->id}}">{{$movie->title}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="col-sm-4 control-label">Show Timing </label>
							<div class="col-sm-8">
								<select class="form-control showTime_id" name="showTime_id">
									<option value="">All Shows</option>
								</select>
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="fixed_deal" class="col-sm-4 control-label">Start Date: </label>
							<div class="col-sm-8">
								 <input type="text" name="startDate" id="date_timepicker_start" class="startDate datetimepicker form-control" autocomplete="off" required>
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="fixed_deal" class="col-sm-4 control-label">Start Time: </label>
							<div class="col-sm-8">
								 <input type="text" name="startTime" class="date_p startTime form-control" autocomplete="off" required>
							</div>
						</div>
					</div>
					<div class="clear"></div>


					<div class="col-md-12">
						<div class="form-group">
							<label for="fixed_deal" class="col-sm-4 control-label">Expire Date: </label>
							<div class="col-sm-8">
								 <input type="text" name="endDate" id="date_timepicker_end" class="endDate form-control datetimepicker" autocomplete="off" required>
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="fixed_deal" class="col-sm-4 control-label">Expire Time: </label>
							<div class="col-sm-8">
								 <input type="text" name="endTime" class="date_p endTime form-control" autocomplete="off" required>
							</div>
						</div>
					</div>
					<div class="clear"></div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="fixed_deal" class="col-sm-4 control-label">Days: </label>

							<div class="col-sm-8">
								<label class="control-label" style="font-size:11px;"><input type="checkbox" name="" class="Alldays" value=""> All</label><br>
								<label class="control-label" style="font-size:11px;"><input type="checkbox" name="days[]" class="days" value="Mon"> Monday</label>
								<label class="control-label" style="font-size:11px;"><input type="checkbox" name="days[]" class="days" value="Tue"> Tuesday</label>
								<label class="control-label" style="font-size:11px;"><input type="checkbox" name="days[]" class="days" value="Wed"> Wednesday</label>
								<label class="control-label" style="font-size:11px;"><input type="checkbox" name="days[]" class="days" value="Thu"> Thursday</label>
								<label class="control-label" style="font-size:11px;"><input type="checkbox" name="days[]" class="days" value="Fri"> Friday</label>
								<label class="control-label" style="font-size:11px;"><input type="checkbox" name="days[]" class="days" value="Sat"> Saturday</label>
								<label class="control-label" style="font-size:11px;"><input type="checkbox" name="days[]" class="days" value="Sun"> Sunday</label>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					
					<div class="col-sm-12" style="height: 20px;"></div>

					{{-- <div class="col-md-12">
						<div class="form-group">
							<label for="fixed_deal" class="col-sm-4 control-label">Day Timing: </label>
							<div class="col-sm-3">
								 <input type="text" name="dayStartTime" class="date_p form-control" autocomplete="off">
							</div>
							<div class="col-sm-2">To</div>
							<div class="col-sm-3">
								 <input type="text" name="dayEndTime" class="date_p form-control" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="clear"></div>
 --}}
					<div class="col-md-12">
						<div class="form-group">
							<label for="fixed_deal" class="col-sm-4 control-label"><span>*</span>Buy Tickets Qty to Get Free Item: </label>
							<div class="col-sm-8">
								 <input type="number" name="buyTicket" min="1" class="buyTicket form-control" autocomplete="off" required>
							</div>
						</div>
					</div>
					<div class="clear"></div>

				</div><!-- col-md-6 -->

				<div class="col-md-4 col-md-offset-2">

					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_actors" class="col-sm-6 control-label"><span>*</span> Deal Status: </label>
							<div class="col-sm-6">
								<select class="form-control status" name="status" required>
									<option value="1">Active</option>
									<option value="2">Planned</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>
					</div>

					<div class="clear"></div>

				</div><!-- col-md-6 -->

				<div class="col-md-12 bottom-label">
					<div class="col-md-6">
						<h3>Get For Free.</h3>
							<span>Select Item, Tickets or Packages for free items.</span>
						</div>

					<div class="col-md-6 form-header-right">
						<button type="button" class="btn submitBtn save-button person_btn" value="" onclick="additem()">Add</button>
					</div>
				</div>

				<div class="col-md-12 label-container">
					<div class="col-md-3">
						Get
					</div>

					<div class="col-md-3">
						Name
					</div>

					<div class="col-md-3">
						Quantity
					</div>

					<div class="col-md-3">
					</div>
				</div><!-- col-md-12 -->

				<div class="col-md-12 ">
					<div id="freeContainer">
						<div class="row">

						</div>
					</div><!-- #Content CLose -->
				</div><!-- col-md-12 -->

			</div><!-- form-container -->
		</div><!-- row -->

	</form>
</div>
<br><br>
@endsection
	
@section('scripts')
	
	<script>

		function additem(){

			var len = $('.row-el').length;
			//console.log(len);
			var div = document.createElement('div');
			div.className = 'row';
			div.innerHTML = `<div class="col-md-12 row-el">
									<div class="col-md-3">	
										<div class="item-group">
										 	<select name="type[]" id="item`+len+`" class="type form-control" required>
												<option selected disabled>Select Any One Type</option>
												<option value="ticket">Tickets</option>
												<option value="item">Item</option>
												<option value="package">Package</option>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="item-group">
											<select name="typeName[]" id="item`+len+`" class="list form-control" required>
												
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="item-group">
											<input type="number" min="1" name="qty[]" class="form-control"   placeholder="0" class="form-control" required>
										</div>
									 </div>
									<div class="col-md-2 col-md-offset-1 txt-center">
										<button type="button" class="btn submitBtn minus-btn" value="" >Remove x</button>
									</div>
								</div>
							</div>`;
			 document.getElementById('freeContainer').appendChild(div);
		}

		$('#freeContainer').on('change mousewheel', '.type', function(){
			var type = $(this).val();
			var list = $(this).parent().parent().parent('.row-el').find('.list');
			$(list).removeAttr('disabled');
			$(list).html('');
			var html = '';
			if(type == 'item'){
				@foreach($items as $item)
				html += '<option value="{{$item->id}}">{{$item->name}}</option>';
				@endforeach
				$(list).html(html);
			}else if(type == 'package'){
				@foreach($packages as $package)
				html += '<option value="{{$package->id}}">{{$package->name}}</option>';
				@endforeach
				$(list).html(html);
			}else{
				$(list).html('<option value="0" selected></option');
			}
		});

		$("#freeContainer").on('click', '.minus-btn', function() {
			$(this).parents('.row-el').parent('.row').remove();
		});
		
		$('.form-container').on('change', '.moive_id', function(){
			var id = $(this).val();
			var html = '';
			var date = new Date('1776, 6, 4, 12, 30, 0, 0')
			$.ajax({
				url: '/getShowTimeByMovie',
				method: 'post',
				dataType: 'json',
				data: {'id':id, '_token':'{{csrf_token()}}'},
				success: function(data){
					html += `<option value="">All Shows</option>`;
					for(var i=0; i<data.length; i++){
						var date = new Date(data[i].dateTime)
						var theDate = date.toDateString()+' '+date.getHours()+':'+date.getMinutes();
						html += `<option value="`+data[i].id+`">`+theDate+`</option>`;
					}
					$('.showTime_id').html(html);
				}
			});
		});

		$('.Alldays').on('click' , function(){
			if($(this).is(':checked')){
				 $('.days').prop("checked", true);
				console.log('ok');
			}else{
				$('.days').prop("checked", false);
				console.log('NotOK');
			}
		});

		$(".form-container").on('click', '.date_p', function(event) {
			$('.date_p').datetimepicker({
				datepicker:false,
				timepicker:true,
				format:'H:i',
				});
			$('.date_p').datetimepicker({step:10});
		});


	</script>	

@endsection