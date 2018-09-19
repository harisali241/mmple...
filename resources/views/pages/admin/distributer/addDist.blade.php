@extends('layouts.master')
@section('content')
	
<div class="container">
	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('distributer') }}">Distributer</a></li>
		  <li class="active">Add Distributer</li>
		</ol>
	</div><!--row-->
	<form class="form-horizontal dashboardForm"  action="{{ route('distributer.store') }}" method="post">
		{{ csrf_field() }}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Distributer Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Add Distributer</button>
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
						<label for="itemname" class="col-sm-4 control-label"><span>* </span>Distributer Name: </label>
						<div class="col-sm-8">
							<input type="text" name="name" id="dist_name" value="" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="dist_description" class="col-sm-4 control-label">Established year: </label>
						<div class="col-sm-8">
							<input type="text" name="establishedYear" id="dist_established_year" value="" class="form-control" >
						</div>
					</div>
				</div>
				<div class="clear"></div>


				<div class="col-md-12">	
					<div class="form-group">
						<label for="dist_description" class="col-sm-4 control-label">Description: </label>
						<div class="col-sm-8">
							<textarea name="description" id="dist_description" row="5" class="form-control" style="height: 80px;"></textarea>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div><!-- col-md-6 -->

			<div class="col-md-6">
			</div><!-- col-md-6 -->
		</div><!-- form-container -->
	</form>
</div><!-- Container Close -->

@endsection