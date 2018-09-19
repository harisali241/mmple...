@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li class="active">Add Logo</li>
		</ol>
	</div><!--row-->
	
	{!! Form::model($logo , ['method' => 'PATCH','url' => ['logo', $logo->id], 'files'=>true, 'class' => 'form-horizontal dashboardForm']) !!}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Logo image</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Submit </button>
			 		</div>
			 	</div>
		 	</div>
		</div>

		@include('includes.error')
		@include('includes.success')

		<div class="form-container">
			<div class="col-md-6">
				<div class="col-md-12 item_img">
				  <div class="form-group">
					<label for="movie_synopsis" class="col-sm-2 control-label">Image: </label>
					<div class="col-sm-10">
						{!!Form::file('logo',null, ['class' => 'form-control', 'value'=>$logo->logo, 'style'=>'width:100%;height: 33px;'])!!}
					</div>
				 </div>					       
				</div>
			</div><!-- col-md-6 -->
				
			<div class="col-md-6">
				<div class="col-md-12 item_img">
				  <img src="{{ asset('assets/images/uploads/'.$logo->logo) }}"/>			       
				</div>
			</div><!-- col-md-6 -->
			
		</div><!-- form-container -->
			
	</form>
	</div>
</div><!-- Container Close -->

@endsection