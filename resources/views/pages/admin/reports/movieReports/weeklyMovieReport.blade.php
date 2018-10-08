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
				 		<button type="button" class="btn submitBtn save-button">Generate Report</button>
			 		</div>
			 	</div>
		 	</div>
		 </div><!--row-->
	</form>

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
	
		<div class="col-md-12">
			<div class="the-box full no-border">
				<div class="table-responsive">
						
					<table border="1" cellpadding="0" cellspacing="0" id="example" class="table table-hover tableView admin-table" style="font-size: 12px; font-weight: bold;font-family: helvetica;">
						
						<thead>					
							<tr> 
								<th style=" font-size: 14px;"><strong>Movie : </strong><strong class="movieName"></strong></th>
								<th style=" font-size: 14px;"><strong> Current time : </strong><strong>{{date('Y-m-d h:i a')}}</strong></th>
							</tr> 
							<tr> 
								<td style=" font-size: 14px;"><strong>Week</strong></td>
								<td style=" font-size: 14px;"><strong>Week ticket total</strong></td>
							</tr>
						</thead>
						
						<tbody class="searchable">
							
						</tbody>
						<tr> 
							<td style=" font-size: 14px;"><strong>Total bookings</strong></td>
							<td style=" font-size: 14px;"><strong class="grandTotal"></strong></td>
						</tr>
						
						<tr> 
							<td style=" font-size: 14px;"><strong>  Weeks * distributer seats/week</strong></td>
							<td style=" font-size: 14px;"><strong class="comp"></strong></td>
						</tr>
						
						<tr> 
							<?php ?>
							<th style=" font-size: 14px;"><strong>50% COST</strong></th>
							<th style=" font-size: 14px;"><strong class="profit"></strong></th>
						</tr>
					</table>

				</div><!-- /.table-responsive -->
			</div>	
		</div><!-- /col-md-12 -->
	
	</div>

</div>

	<div class="voucher printPirnter" style="visibility:hidden;">
		<div class="border" style="margin-top:5px;"></div>

		<table  class=" border" cellpadding="1" cellspacing="1" style="text-align:center;width:700px;margin:auto;font-size: 10px; font-weight: bold;font-family: helvetica; ">
			<thead>
				<tr> 
					<th style=" font-size: 14px;text-align:center;"><strong>Movie : </strong><strong class="movieName"></strong></th>
					<th style=" font-size: 14px;text-align:center;"><strong> Current time : </strong><strong>{{date('Y-m-d h:i a')}}</strong></th>
				</tr> 
				<tr> 
					<td style=" font-size: 14px;text-align:center;"><strong>Week</strong></td>
					<td style=" font-size: 14px;text-align:center;"><strong>Week ticket total</strong></td>
				</tr>
			</thead>

			<tbody class="searchable">
							   
			</tbody>

			<tr> 
				<td style=" font-size: 14px;"><strong>Total bookings</strong></td>
				<td style=" font-size: 14px;"><strong class="grandTotal"></strong></td>
			</tr>
			<tr> 
				<td style=" font-size: 14px;"><strong>  Weeks * distributer seats/week</strong></td>
				<td style=" font-size: 14px;"><strong class="comp"></strong></td>
			</tr>
			<tr>
				<th style=" font-size: 14px;text-align:center;"><strong>50% COST</strong></th>
				<th style=" font-size: 14px;text-align:center;"><strong class="profit"></strong></th>
			</tr>
		</table>		

		<div class="voucher printPirnter border" style="margin-top:5px;"></div>	
		
	</div>

@endsection

@section('scripts')

	<script type="text/javascript">
		$('.admin-table').hide();
		$('.save-button').on('click', function(){
			var id = $('.goRecord').val();
			
			$.ajax({
				url: baseUrl+'weeklyMovieReports',
				method: 'post',
				dataType: 'json',
				data:{'id':id, '_token':'{{csrf_token()}}'},
				success: function(data){
					console.log(data);
					$('.admin-table').show();
					$('.searchable').html('');
					var html = '';
					var count = 1;
					var  grandTotal = 0;
					if(data.weeklyRecord.length > 0){;
						for(var i=0; i< data.weeklyRecord.length; i++)
	                	{	
	                		html += `
							<tr>
								<td>`+count+`</td>
								<td>`+data.weeklyRecord[i].price+`</td>
							</tr>
							`;
							grandTotal += data.weeklyRecord[i].price;
							count++;
	                	}
					}else{
						$('.admin-table').hide();
					}

					$('.comp').text('- '+data.compPrice);
					$('.grandTotal').html(grandTotal);
					$('.searchable').html(html);
					var pro = (grandTotal - data.compPrice)/2;
					$('.profit').html(pro);
					$('.movieName').html(data.movie);
				}
			});

		});

	</script>

@endsection