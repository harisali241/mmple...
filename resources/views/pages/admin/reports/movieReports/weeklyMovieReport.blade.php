@extends('layouts.master')
@section('content')

<div class="container no-print">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="index.php">Home</a></li>
		  <li><a href="{{url('/movieReport')}}">Reports Ticket</a></li>
		  <li class="active">Seats bookings by day</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm"  action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Todays Seats Booking</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" onclick="window.print()" name="">Print</button>
				 		<button type="submit" class="btn submitBtn save-button">Generate Report</button>
			 		</div>
			 	</div>
		 	</div>
		 </div><!--row-->

		<div class="form-container">
				
			<div class="col-md-6">
				<div class="col-md-12 t_select" id="showtime_movie_id">	
					<div class="form-group">
						<label for="showtime_movie_id"  class="col-sm-4 control-label"><span>* </span> Show Movie: </label>
						<div class="col-sm-8">
							<select class="form-control goRecord" required>
								<option value="" selected disabled >Select Movie</option>
								@foreach($movies as $movie)
									<option value="{{$movie->id}}">{{$movie->title}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

			</div><!-- col-md-6 -->
			<div class="col-md-6"></div><!-- col-md-6 -->
	</form>
		
	<div class="col-md-12">
		<div class="the-box full no-border">
			<div class="table-responsive">
					
				<table border="1" cellpadding="0" cellspacing="0" id="example" class="table table-hover tableView admin-table" style="font-size: 12px; font-weight: bold;font-family: helvetica;">
					
					<thead>					
						<tr> 
							<th style=" font-size: 14px;"><strong>Movie : </strong><strong>movie_title</strong></th>
							<th style=" font-size: 14px;"><strong> Current time : </strong><strong>current_date_time</strong></th>
						</tr> 
						<tr> 
							<td style=" font-size: 14px;"><strong>Week</strong></td>
							<td style=" font-size: 14px;"><strong>Week ticket total</strong></td>
						</tr>
					</thead>
					
					<tbody class="searchable">
						<tr>
							<td>key</td>
							<td>week_total</td>
						</tr>
							
						<tr> 
							<td style=" font-size: 14px;"><strong>Total bookings</strong></td>
							<td style=" font-size: 14px;"><strong>total_sale</strong></td>
						</tr>
						
						<tr> 
							<td style=" font-size: 14px;"><strong>  Weeks * distributer seats/week</strong></td>
							<td style=" font-size: 14px;"><strong>comp_total</strong></td>
						</tr>
						
						<tr> 
							<?php ?>
							<th style=" font-size: 14px;"><strong>50% COST</strong></th>
							<th style=" font-size: 14px;"><strong>(total_sale-comp_total)/2</strong></th>
						</tr>
						   
					</tbody>
				</table>

			</div><!-- /.table-responsive -->
		</div>	
	</div><!-- /col-md-12 -->
			
</div>

	<div class="voucher printPirnter" style="visibility:hidden;">
		<div class="border" style="margin-top:5px;"></div>				

		<div class="voucher printPirnter border" style="margin-top:5px;"></div>	
		
	</div>

@endsection

@section('scripts')

	<script type="text/javascript">
		
		$('.goRecord').on('change', function(){
			var id = $(this).val();

			$.ajax({
				url: 'weeklyMovieReports',
				method: 'post',
				dataType: 'json',
				data:{'id':id, '_token':'{{csrf_token()}}'},
				success: function(show){

				}
			});

		});

	</script>

@endsection