@extends('layouts.master')
@section('content')

	
<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('screen') }}">Screens</a></li>
		  <li class="active">Update Screen</li>
		</ol>
	</div><!--row-->

	{!! Form::model($screen , ['method' => 'PATCH','url' => ['screen', $screen->id], 'files'=>true, 'class' => 'form-horizontal dashboardForm']) !!}
		
		<div class="row gray-header">
				<div class="col-md-12">
					<div class="form-header-inner">
						<div class="col-sm-6">
							<h3> Screen Details</h3>
						</div>
				 		<div class="col-sm-6 action_btn">
				 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
					 		<button type="submit" class="btn submitBtn save-button">Save Changes</button>
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
							{!! Form::text('name' , null ,['id' => 'screen_name' ,'class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="col-md-12">	
					<div class="form-group">
						<label for="screen_total_seats" class="col-sm-4 control-label"><span>* </span> Total Seats: </label>
						<div class="col-sm-8">
							{!! Form::text('totalSeats' , null ,['id' => 'screen_total_seats' ,'class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>

				<div class="clear"></div>
				<div class="col-md-12">	
					<div class="form-group">
						<label for="screen_house_seats" class="col-sm-4 control-label">House Seats: </label>
						<div class="col-sm-8">
							{!! Form::text('houseSeats' , null ,['id' => 'screen_house_seats' ,'class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="screen_wheel_chair_seats" class="col-sm-4 control-label">Wheel Chair Seats: </label>
						<div class="col-sm-8">
							{!! Form::text('wheelChairSeats' , null ,['id' => 'screen_wheel_chair_seats' ,'class' => 'form-control']) !!}
						</div>
					</div>
				</div>

				
			
			</div><!-- col-md-6 -->

			<div class="col-md-4 col-md-offset-2">
				@if($screen->image != '')
					<div class="profilePic">
			           <span>
			            <img src="{{ asset('assets/images/uploads/m_'.$screen->image)}}" class="img-responsive" alt="">
			            <a id="removeProfilePic"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
			           </span>
			        </div>

			        <div class="form-group" id="showNewPicSubmit" style="display:none;">
						<label for="movie_synopsis" class="col-sm-2 control-label">Image: </label>
						<div class="col-sm-10">
							{!! Form::File('image' , ['class' => 'form-control', 'style' => 'width:100%;height:33px;']) !!}
						</div>
					</div>
				@else
			        <div class="form-group">
						<label for="movie_synopsis" class="col-sm-2 control-label">Image: </label>
						<div class="col-sm-10">
							{!! Form::File('image' , ['class' => 'form-control', 'style' => 'width:100%;height:33px;']) !!}
						</div>
					</div>
				@endif
				
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
					@php
						$rows = json_decode($screen->rows);
						$columns = json_decode($screen->columns);
					@endphp
					@for($i=0; $i < count($rows); $i++)
						<div class="col-md-12 row-el">
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-sm-4 control-label">Row Name</label>
									<div class="col-sm-8">
										<input type="text" name="rows[]" id="screen_rows" value="{{$rows[$i]}}" class="form-control" required>
									</div>
							  	</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label class="col-sm-5 control-label">Seats per Row</label>
									<div class="col-sm-6">
										<input type="number" name="columns[]" id="row_columns" value="{{$columns[$i]}}" class="form-control" required>
									</div>
								</div>
							</div>
							<div class="col-md-3 txt-center">
								<button type="button" class="btn submitBtn minus-btn" value="" >Remove x</button>
							</div>
						</div>
					@endfor
				</div><!-- #Content CLose -->
			</div><!-- col-md-12 -->	

		 </div><!-- form-container -->
	  </form>
 </div><!-- form-container -->

</div>
<br><br>

@endsection

@section('scripts')

	<script>

        function addRow() {
		var div = document.createElement('div');
		div.className = 'row';
		div.innerHTML = '<div class="col-md-12 row-el">\
							<div class="col-md-4">\
								<div class="form-group">\
									<label class="col-sm-4 control-label">Row Name</label>\
									<div class="col-sm-8">\
										<input type="text" name="rows[]" id="screen_rows" value="" class="form-control" required>\
									</div>\
							  	</div>\
							</div>\
							<div class="col-md-5">\
								<div class="form-group">\
									<label class="col-sm-5 control-label">Seats per Row</label>\
									<div class="col-sm-6">\
										<input type="number" name="columns[]" id="row_columns" value="" class="form-control" required>\
									</div>\
								</div>\
							</div>\
							<div class="col-md-3 txt-center">\
								<button type="button" class="btn submitBtn minus-btn" value="" >Remove x</button>\
							</div>\
						</div>';
		document.getElementById('content').appendChild(div);
		}

		// Minus Button function for Offer Page
		$("#content").on('click', '.minus-btn', function() {
			$(this).parents('.row-el').remove();
		});

	</script>

@endsection