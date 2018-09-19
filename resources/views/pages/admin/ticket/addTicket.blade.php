@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('ticket') }}">Tickets</a></li>
		  <li class="active">Add Ticket</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm"  action="{{ route('ticket.store') }}" method="post">
		{{csrf_field()}}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Ticket Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Add Ticket</button>
			 		</div>
			 	</div>
		 	</div>
		</div><!--row-->
		
		@include('includes.error')
		@include('includes.success')

		<div class="form-container" id="ticket_container">
				
			<div class="col-md-6">
			
				<div class="clear"></div>
				<div class="col-md-12">	
					<div class="form-group">
						<label for="itemname" class="col-sm-4 control-label"><span>*</span> Ticket Name: </label>
						<div class="col-sm-8">
							<input type="text" name="title" id="ticket_title" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_desc" class="col-sm-4 control-label">Description: </label>
						<div class="col-sm-8">
							<input type="text" name="description" id="ticket_desc" class="form-control">
						</div>
					</div>
				</div>

				<div class="clear"></div>
				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_class" class="col-sm-4 control-label">Ticket Class: </label>
						<div class="col-sm-8">
							<select class="form-control" name="class">
								<option value="" selected disabled>select</option>
								@foreach(ticketClass() as $class)
									<option value="{{$class}}">{{$class}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_ischild" class="col-sm-4 control-label"><span>*</span> Is Child: </label>
						<div class="col-sm-8">
							<select class="form-control" name="isChild" required>
								<option value="" selected disabled>select</option>
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_adult_price" class="col-sm-4 control-label"><span>*</span> Adult Ticket Price: </label>
						<div class="col-sm-8">
							<input type="text" name="adultPrice" id="ticket_adult_price" class="form-control" required >
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_child_price" class="col-sm-4 control-label">Child Ticket Price: </label>
						<div class="col-sm-8">
							<input type="text" name="childPrice" id="ticket_child_price" class="form-control" >
						</div>
					</div>
				</div>
				
				<div class="clear"></div>
				

				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_class" class="col-sm-4 control-label"><span>*</span> Ticket Type: </label>
						<div class="col-sm-8">
							<select class="form-control" name="type" required>
								<option value="" selected disabled>select</option>
								@foreach(ticketType() as $ticketType)
									<option value="{{$ticketType}}">{{$ticketType}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

			
			</div><!-- col-md-6 -->

			<div class="col-md-6">

				<div class="col-md-offset-5 col-md-7">	
					<div class="form-group">
						<label for="itemname" class=" col-sm-5 control-label"><span>*</span> Ticket Status: </label>
						<div class="col-sm-7">
							<select class="form-control status" name="status" required>
								<option value="1">Acive</option>
								<option value="2">Planned</option>
								<option value="0">Inactive</option>
							</select>
						</div>
					</div>
				</div>

			</div><!-- col-md-6 -->
		</div>
	</form>
</div><!-- Container Close -->

@endsection