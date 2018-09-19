@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('item') }}">Item</a></li>
		  <li class="active">Add Item</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm"  action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Item Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Add Item</button>
			 		</div>
			 	</div>
		 	</div>
		</div><!--row-->
		
		@include('includes.error')
		@include('includes.success')
	
		<div class="form-container">
			<div class="col-md-6">
				<div class="col-md-12">	
					<div class="form-group">
						<label for="item_name" class="col-sm-4 control-label"><span>* </span>Item Name: </label>
						<div class="col-sm-8">
							<input type="text" name="name" id="item_name" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="item_small_decs" class="col-sm-4 control-label"><span>* </span>Item Description: </label>
						<div class="col-sm-8">
							<input type="text" name="description" id="item_small_decs" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				
				<div class="col-md-12">	
					<div class="form-group">
						<label for="item_measuring_unit" class="col-sm-4 control-label"><span>* </span>Measuring Unit	: </label>
						<div class="col-sm-8">
							<select name="measuringUnit" class="form-control" required>
								<option value="" selected disabled>select</option>
								@foreach(measuringUnit() as $unit)
									<option value="{{$unit}}">{{$unit}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="clear"></div>
				<div class="col-md-12">	
					<div class="form-group">
						<label for="item_category" class="col-sm-4 control-label">Item Category: </label>
						<div class="col-sm-8">
							<select name="foodCategory_id" class="form-control">
								<option selected disabled>select</option>
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
						<label for="item_default_price" class="col-sm-4 control-label"><span>* </span>Default Price: </label>
						<div class="col-sm-8">
							<input type="text" name="defaultPrice" id="item_default_price" class="form-control" required >
						</div>
					</div>
				</div>

				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="item_cost_price" class="col-sm-4 control-label"><span>* </span> Cost Price: </label>
						<div class="col-sm-8">
							<input type="text" name="costPrice" id="item_cost_price" class="form-control" required>
						</div>
					</div>
				</div>

		    	<div class="clear"></div>


	

		    	<div class="col-md-12">	
					<div class="form-group">
						<label for="item_img" class="col-sm-4 control-label">Display Order #: </label>
						<div class="col-sm-8">
							<input type="number" name="displayOrder" id="item_display_order" class="form-control" >
						</div>
					</div>
				</div>

		    	<div class="clear"></div>
				

		    	<div class="col-md-12">	
					<div class="form-group">
						<label for="item_img" class="col-sm-4 control-label">Item bg: </label>
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
						<label for="item_status" class="col-sm-4 control-label"><span>* </span>Status: </label>
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
							 <input type="file" name="image" class="form-control" style="width:100%;height: 33px;" required>
						</div>
					 </div>
				</div>

			</div><!-- col-md-6 -->
		</div><!-- form-container -->
	</form>
</div><!-- Container Close -->

@endsection