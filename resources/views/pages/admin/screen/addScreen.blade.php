@extends('layouts.master')
@section('content')

	
<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('screen') }}">Screens</a></li>
		  <li class="active">Add Screen</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm"  action="{{ route('screen.store') }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="row gray-header">
				<div class="col-md-12">
					<div class="form-header-inner">
						<div class="col-sm-6">
							<h3> Screen Details</h3>
						</div>
				 		<div class="col-sm-6 action_btn">
				 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
					 		<button type="submit" class="btn submitBtn save-button">Add Film</button>
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
						<label for="screen_name" class="col-sm-4 control-label"><span>* </span>Screen Name: </label>
						<div class="col-sm-8">
							<input type="text" name="name" id="screen_name" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="col-md-12">	
					<div class="form-group">
						<label for="screen_total_seats" class="col-sm-4 control-label"><span>* </span> Total Seats: </label>
						<div class="col-sm-8">
							<input type="text" name="totalSeats" id="screen_total_seats" class="form-control" required readonly>
						</div>
					</div>
				</div>

				<div class="clear"></div>
				<div class="col-md-12">	
					<div class="form-group">
						<label for="screen_house_seats" class="col-sm-4 control-label">House Seats: </label>
						<div class="col-sm-8">
							<input type="text" name="houseSeats" id="screen_house_seats" class="form-control" required>
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="screen_wheel_chair_seats" class="col-sm-4 control-label">Wheel Chair Seats: </label>
						<div class="col-sm-8">
							<input type="text" name="wheelChairSeats" id="screen_wheel_chair_seats" class="form-control" >
						</div>
					</div>
				</div>

				
			
			</div><!-- col-md-6 -->

			<div class="col-md-4 col-md-offset-2">
		         <div class="form-group">
					<label for="movie_synopsis" class="col-sm-2 control-label">Image: </label>
					<div class="col-sm-10">
						 <input type="file" name="image" class="form-control" style="width:100%;height: 33px;">
					</div>
				 </div>
			</div><!-- col-md-6 -->

			<div class="col-md-12 bottom-label">
				<div class="col-md-6">
					<h3>Rows and Seats count.</h3>
					<span>Add or remove Rows and their seats for this screen below</span>
				</div>

				<div class="col-md-6 form-header-right">
					<button type="button" class="btn submitBtn person_btn save-button" value="" onclick="addRow()">Add Row</button>
				</div>
			</div><!-- col-md-12 -->


			<div class="col-md-12 ">
				<div id="content">
				
				</div><!-- #Content CLose -->
			</div><!-- col-md-12 -->	

		 </div><!-- form-container -->
	  </form>
 </div><!-- form-container -->

</div>
@endsection

@section('scripts')

	<script>
			// var rowVal = $(this).parent().parent().parent().parent('.row-el').find('.rowVal').val();
			// console.log(colVal+' '+rowVal);
		var total_seats = 0;
		var ispresent = [];
		var preCol = 0;
		var count = 1;
		$('#content').on('focusin', '.columns', function(){
			preCol = $(this).val();
		});
		$('#content').on('focusout', '.columns', function(){
			var cols = $(this).val();
			var rowVal = $(this).parent().parent().parent().parent('.row-el').find('.rowVal').val();
			var id = $(this).parent().parent().parent().parent('.row-el').attr('id');
			$(document).ready(function(){

				if($.inArray(id, ispresent) == -1){
					ispresent.push(id);
					total_seats += +cols;
				}else{
					if(preCol>cols){
						var c_col = preCol - cols;
						total_seats -= c_col;
					}else if(preCol<cols){
						var c_col = cols - preCol;
						total_seats += +c_col;
					}
				}
				$('#screen_total_seats').val(total_seats);
			})
		});
		
        function addRow() {
			var div = document.createElement('div');
			div.className = 'row';
			div.innerHTML = `<div class="col-md-12 row-el" id="row-el`+count+`">
								<div class="col-md-4">
									<div class="form-group">
										<label class="col-sm-4 control-label">Row Name</label>
										<div class="col-sm-8">
											<input type="text" name="rows[]" id="screen_rows" value="" class="form-control rowVal" required>
										</div>
								  	</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label class="col-sm-5 control-label">Seats per Row</label>
										<div class="col-sm-6">
											<input type="number" name="columns[]" min="1" value="" class="form-control columns" required>
										</div>
									</div>
								</div>
								<div class="col-md-3 txt-center">
									<button type="button" class="btn submitBtn minus-btn" value="" >Remove x</button>
								</div>
							</div>`;
			document.getElementById('content').appendChild(div);
			count++;
		}

		// Minus Button function for Offer Page
		$("#content").on('click', '.minus-btn', function() {
			var cc = $(this).parent().parent().find('.columns').val();
			total_seats -= cc;
			$('#screen_total_seats').val(total_seats);
			$(this).parents('.row-el').parent('.row').remove();
			if($(this).parents('.row-el').length == 0){
				$('#screen_total_seats').val(0);
			}
		});

	</script>

@endsection