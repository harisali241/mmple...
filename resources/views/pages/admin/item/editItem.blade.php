@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('item') }}">Item</a></li>
		  <li class="active">Update Item</li>
		</ol>
	</div><!--row-->

	{!! Form::model($item , ['method' => 'PATCH','url' => ['item', $item->id], 'files'=>true, 'class' => 'form-horizontal dashboardForm']) !!}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Item Details</h3>
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
	
		<div class="form-container">
			<div class="col-md-6">
				<div class="col-md-12">	
					<div class="form-group">
						<label for="item_name" class="col-sm-4 control-label"><span>* </span>Item Name: </label>
						<div class="col-sm-8">
							{!! Form::text('name' , null ,['id' => 'item_name' ,'class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="item_small_decs" class="col-sm-4 control-label"><span>* </span>Item Description: </label>
						<div class="col-sm-8">
							{!! Form::text('description' , null ,['id' => 'item_small_decs' ,'class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>
				<div class="clear"></div>

					
				<div class="col-md-12">	
					<div class="form-group">
						<label for="item_measuring_unit" class="col-sm-4 control-label"><span>* </span>Measuring Unit	: </label>
						<div class="col-sm-8">
							{!! Form::select('measuringUnit', measuringUnit(), null,['class' => 'form-control', 'required' => 'required']) !!}
							{{-- <select name="measuringUnit" class="form-control" required>
								<option value="" selected disabled>select</option>
								@foreach(units() as $unit)
									<option value="{{$unit}}" @if($item->measuringUnit == $unit) {{'selected = "selected"'}} @endif>{{ $unit }}</option>
								@endforeach
							</select> --}}
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
									<option value="{{ $food->id }}" @if($item->foodCategory_id == $food->id) {{'selected = "selected"'}} @endif>{{ $food->name }}</option>
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
							{!! Form::text('defaultPrice' , null ,['id' => 'item_default_price' ,'class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>

				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="item_cost_price" class="col-sm-4 control-label"><span>* </span> Cost Price: </label>
						<div class="col-sm-8">
							{!! Form::text('costPrice' , null ,['id' => 'item_cost_price' ,'class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>

		    	<div class="clear"></div>

		    	<div class="col-md-12">	
					<div class="form-group">
						<label for="item_img" class="col-sm-4 control-label">Display Order #: </label>
						<div class="col-sm-8">
							{!! Form::number('displayOrder' , null ,['id' => 'item_display_order' ,'class' => 'form-control']) !!}
						</div>
					</div>
				</div>

		    	<div class="clear"></div>
				
				
		    	<div class="col-md-12">	
					<div class="form-group">
						<label for="item_img" class="col-sm-4 control-label">Item bg: </label>
						<div class="col-sm-8">
							<select class="form-control" name="bgColor" id="item_bg" style="background-color:{{$item->bgColor}};" required>
								<option value="" selected disabled>Select below</option>
								@foreach(bgColor() as $color)
									<option value="{{ $color }}" style="background-color:{{ $color }};" @if($item->bgColor == $color) {{'selected = "selected"'}} @endif></option>
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
							{!! Form::select('status',[ '0' => 'Inactive' ,'1' => 'Active', '2' => 'Planned' ], null,['class' => 'form-control status']) !!}
						</div>
					</div>
				</div>

	    		<div class="clear"></div>

				<div class="col-md-12 item_img">
					@if($item->image != '')
						<div class="profilePic">
				           <span>
				            <img src="{{ asset('assets/images/uploads/m_'.$item->image) }}" class="img-responsive" alt="">
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
								{!! Form::file('image' , null ,['class' => 'form-control', 'style' => 'width:100%;height: 33px;', 'required'=> 'required']) !!}
							</div>
						 </div>
					@endif
			         
				</div>

			</div><!-- col-md-6 -->
		</div><!-- form-container -->
	</form>
</div><!-- Container Close -->

@endsection