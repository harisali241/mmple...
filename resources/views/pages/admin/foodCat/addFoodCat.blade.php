@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li><a href="{{ url('foodCategories') }}">Food categories</a></li>
		  <li class="active">Add Category</li>
		</ol>
	</div><!--row-->
	<form class="form-horizontal dashboardForm"  action="{{ route('foodCategories.store') }}" method="post">
		{{ csrf_field() }}
		<div class="row gray-header">
				<div class="col-md-12">
					<div class="form-header-inner">
						<div class="col-sm-6">
							<h3> Category Details</h3>
						</div>
				 		<div class="col-sm-6 action_btn">
				 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
					 		<button type="submit" class="btn submitBtn save-button">Add Category</button>
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
							<label for="food_category_name" class="col-sm-4 control-label"><span>* </span>Category Name: </label>
							<div class="col-sm-8">
								<input type="text" name="name" id="food_category_name" class="form-control" required>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6"></div>
			</div><!-- form-container -->
		</div><!-- row -->
			
	</form>
</div><!-- Container Close -->

@endsection