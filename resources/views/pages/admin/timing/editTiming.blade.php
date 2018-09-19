@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li>Settings</li>
		  <li class="active">Timings</li>
		</ol>
	</div><!--row-->

	{!! Form::model($timing , ['method' => 'PATCH','url' => ['timing', $timing->id], 'files'=>true, 'class' => 'form-horizontal dashboardForm']) !!}
		<div class="row gray-header">
				<div class="col-md-12">
					<div class="form-header-inner">
						<div class="col-sm-6">
							<h3>Timing Details</h3>
						</div>
				 		<div class="col-sm-6 action_btn">
				 			<button type="button" class="btn submitBtn cancel-button">Cancel</button>
					 		<button type="submit" class="btn submitBtn save-button">Save Changes </button>
					 		
				 		</div>
				 	</div>
			 	</div>
		</div><!--row-->

		@include('includes.error')
		@include('includes.success')
		
		<div class="row">
	
			<div class="form-container" style="padding-top:0px;">
			<div class="col-md-12 bottom-label" style="margin-bottom:20px;">
				<p style="font-size: 16px; padding: 5px;">These settings change your default settings for the non movie time of each show</p>
			</div>

			<div class="col-md-6">
				<div class="col-md-12">	
					<div class="form-group">
						<label for="timing_cleanup" class="col-sm-4 control-label"><span>* </span>Trailor Duration: </label>
						<div class="col-sm-8">
							<input type="number" min="0" name="trailerDuration" id="timing_trailor" value="{{ $timing->trailerDuration }}" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="timing_interval" class="col-sm-4 control-label"><span>* </span> Interval Duration: </label>
						<div class="col-sm-8">
							<input type="number" min="0" name="intervalDuration" id="timing_interval" value="{{ $timing->intervalDuration }}" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="timing_trailor" class="col-sm-4 control-label"><span>* </span> Cleanup Duration: </label>
						<div class="col-sm-8">
							<input type="number" min="0" name="cleanUpDuration" id="timing_cleanup" value="{{ $timing->cleanUpDuration }}" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				

		 </div><!-- form-container -->
	</form>
 </div><!-- form-container -->
</div>
</div>

@endsection