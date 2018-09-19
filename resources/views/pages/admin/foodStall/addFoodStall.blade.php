@extends('layouts.master')
@section('content')
	
	
<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('/foodStall') }}">Food Stalls</a></li>
		  <li class="active">Add Food Stall</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm"  action="{{ route('foodStall.store') }}" method="post">
		{{ csrf_field() }}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Food Stall Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Add Food Stall</button>
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
						<label for="foodstall_name" class="col-sm-4 control-label"><span>* </span>Stall Name: </label>
						<div class="col-sm-8">
							<input type="text" name="name" id="foodstall_name" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="foodstall_size" class="col-sm-4 control-label"><span>* </span>Size: </label>
						<div class="col-sm-8">
							<input type="text" name="size" id="foodstall_size" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="item_name" class="col-sm-4 control-label"><span>* </span>Contract Type: </label>
						<div class="col-sm-8">
							<select class="form-control" name="contractType" required>
								<option value="Yearly">Yearly</option>
							</select>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="foodstall_contract_amount" class="col-sm-4 control-label"><span>* </span>Amount: </label>
						<div class="col-sm-8">
							<input type="text" name="contractAmount" id="foodstall_contract_amount" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="foodstall_date" class="col-sm-4 control-label"><span>* </span>Contract Date: </label>
						<div class="col-sm-8">
							<input type="text" name="date" id="foodstall_date" class="form-control datetimepicker" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="foodstall_desc" class="col-sm-4 control-label">Description: </label>
						<div class="col-sm-8">
							<textarea name="description" id="foodstall_desc" row="5" class="form-control" style="height: 80px;"></textarea>
						</div>
					</div>
				</div>
				<div class="clear"></div>
		    	
			</div><!-- col-md-6 -->

			<div class="col-md-offset-2 col-md-4">

				<div class="col-md-8">	
					<div class="form-group">
						<label for="foodstall_status" class="col-sm-4 control-label"><span>* </span>Status: </label>
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
				
			</div><!-- col-md-6 -->
		</div><!-- form-container -->
	</form>
</div><!-- Container Close -->

@endsection