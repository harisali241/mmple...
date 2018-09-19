@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('ticket') }}">Tickets</a></li>
		  <li class="active">Update Ticket</li>
		</ol>
	</div><!--row-->

	{!! Form::model($ticket , ['method' => 'PATCH','url' => ['ticket', $ticket->id], 'files'=>true, 'class' => 'form-horizontal dashboardForm']) !!}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Ticket Details</h3>
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

		<div class="form-container" id="ticket_container">
				
			<div class="col-md-6">
			
				<div class="clear"></div>
				<div class="col-md-12">	
					<div class="form-group">
						<label for="itemname" class="col-sm-4 control-label"><span>*</span> Ticket Name: </label>
						<div class="col-sm-8">
							{!! Form::text('title' , null ,['id' => 'ticket_title' ,'class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_desc" class="col-sm-4 control-label">Description: </label>
						<div class="col-sm-8">
							{!! Form::text('description' , null ,['id' => 'ticket_desc' ,'class' => 'form-control']) !!}
						</div>
					</div>
				</div>

				<div class="clear"></div>
				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_class" class="col-sm-4 control-label">Ticket Class: </label>
						<div class="col-sm-8">
							{!! Form::select('class', ticketClass(), null ,['class' => 'form-control']) !!}
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_ischild" class="col-sm-4 control-label"><span>*</span> Is Child: </label>
						<div class="col-sm-8">
							{!! Form::select('isChild',[ '1' => 'Yes' ,'0' => 'No'], null,['class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_adult_price" class="col-sm-4 control-label"><span>*</span> Adult Ticket Price: </label>
						<div class="col-sm-8">
							{!! Form::text('adultPrice' , null ,['id' => 'ticket_adult_price' ,'class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_child_price" class="col-sm-4 control-label">Child Ticket Price: </label>
						<div class="col-sm-8">
							{!! Form::text('childPrice' , null ,['id' => 'ticket_child_price' ,'class' => 'form-control']) !!}
						</div>
					</div>
				</div>
				
				<div class="clear"></div>
				

				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_class" class="col-sm-4 control-label"><span>*</span> Ticket Type: </label>
						<div class="col-sm-8">
							{!! Form::select('type', ticketType(), null,['class' => 'form-control', 'required' => 'required']) !!}
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
							{!! Form::select('status',[ '0' => 'Inactive' ,'1' => 'Active', '2' => 'Planned' ], null,['class' => 'form-control status']) !!}
						</div>
					</div>
				</div>

			</div><!-- col-md-6 -->
		</div>
	</form>
</div><!-- Container Close -->

@endsection