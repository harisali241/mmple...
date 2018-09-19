@extends('layouts.master')
@section('content')
	
<div class="container">
	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ asset('/') }}">Home</a></li>
		  <li><a href="{{ asset('distributer') }}">Distributer</a></li>
		  <li class="active">Update Distributer</li>
		</ol>
	</div><!--row-->
	{!! Form::model($distributer , ['method' => 'PATCH','url' => ['distributer', $distributer->id], 'files'=>true, 'class' => 'form-horizontal dashboardForm']) !!}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Distributer Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button">Cancel</button>
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
						<label for="itemname" class="col-sm-4 control-label"><span>* </span>Distributer Name: </label>
						<div class="col-sm-8">
							{!! Form::text('name' , null ,['id' => 'dist_name' ,'class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="dist_description" class="col-sm-4 control-label">Established year: </label>
						<div class="col-sm-8">
							{!! Form::text('establishedYear' , null ,['id' => 'dist_established_year' ,'class' => 'form-control']) !!}
						</div>
					</div>
				</div>
				<div class="clear"></div>


				<div class="col-md-12">	
					<div class="form-group">
						<label for="dist_description" class="col-sm-4 control-label">Description: </label>
						<div class="col-sm-8">
							{!! Form::textarea('description',null, ['class' => 'form-control', 'style' => 'height: 80px;', 'row' => '5']) !!}
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