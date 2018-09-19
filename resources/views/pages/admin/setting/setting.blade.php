@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li class="active">Add Settings</li>
		</ol>
	</div><!--row-->
	
	{!! Form::model($setting , ['method' => 'PATCH','url' => ['setting', $setting->id], 'files'=>true, 'class' => 'form-horizontal dashboardForm']) !!}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Add Settings</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Submit </button>
			 		</div>
			 	</div>
		 	</div>
	    </div><!--row-->

	    @include('includes.error')
		@include('includes.success')
		
		<div class="form-container">
			<div class="col-md-8">
				<div class="col-md-12 item_img">
				  <div class="form-group">
					<label for="movie_synopsis" class="col-sm-5 control-label">Disable popups (Customer screen): </label>
					<div class="col-sm-3">
						{!! Form::select('value',[ '1' => 'Yes' ,'0' => 'No',], null,['class' => 'form-control status', 'required'=>'required']) !!}
					</div>
				 </div>					       
				</div>
			</div><!-- col-md-6 -->
		</div><!-- form-container -->
		
	</form>
</div><!-- Container Close -->

@endsection