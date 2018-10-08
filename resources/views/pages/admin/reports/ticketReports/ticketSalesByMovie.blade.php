@extends('layouts.master')
@section('content')


<style>
@media print {
  body {
    visibility: visible;
  }

  .no-print, .footer-container{
    display: none; 
  }

  .printPirnter {
    display: block !important; 
  }

  .voucher * {
    visibility: visible;
  }

  .voucher {
    visibility: visible;
  }
}
</style>

<div class="container">

	<div class="row  no-print">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li><a href="{{url('customReport')}}">Reports Ticket</a></li>
		  <li class="active">Ticket Sales By Movie</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm no-print"  action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Ticket Sales By Movie</h3>
						<img alt="logo" src="{{ asset('assets/header-logo.png') }}">
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" onclick="window.print()" name="">Print</button>
				 		<button type="button" class="btn submitBtn save-button">Generate Report</button>
			 		</div>
			 	</div>
		 	</div>
	  	</div><!--row-->
	</form>
	
	<div class="form-container no-print" >			
		<div class="col-md-6">
			<div class="col-md-12">	
				<div class="form-group">
					<label for="" class="col-sm-4 control-label"><span>*</span>  Date: </label>
					<div class="col-sm-8">
						<input type="text" value="" class="form-control date_pp goDate">
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<br><br>	
			<div class="col-md-12 t_select" id="showtime_movie_id"  >
				<div class="form-group">
					<label for="showtime_movie_id" class="col-sm-4 control-label"><span>* </span> Show Movie: </label>
					<div class="col-sm-8">
						<select class="form-control goMovie" required>
							<option value=""  selected disabled >Select Movie</option>
							@foreach ($movies as $movie)
								<option value="{{$movie->id}}">{{$movie->title}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div><!-- col-md-6 -->

		<div class="col-md-6"></div><!-- col-md-6 -->
	
		<div class="col-md-12  no-print">
			<div class="the-box full no-border">
				<div class="table-responsive">
					<table border="1" cellpadding="0" cellspacing="0" id="example" class="table table-hover tableView admin-table" style=" font-size: 12px; font-weight: bold;font-family: helvetica;">
						<thead>
							<tr>
								<th style=" font-size: 14px;"><strong>Report Date : </strong><strong class="repDate"></strong></th>
								<th style=" font-size: 14px;"></th>
								<th style=" font-size: 14px;"></th>
								<th style=" font-size: 14px;"></th>
								<th style=" font-size: 14px;"><strong> Current time : </strong><strong class="c_date"></strong></th>
								<th style=" font-size: 14px;"></th>

							</tr>
							<tr>
								<td>Showtime </td>
								<td>Screen </td>
								<td>Qty</td>
								<td>Deal Qty</td>
								<td>Complimentary Qty</td>
								<td>Price</td>
							</tr>
						</thead>
						<tbody class="searchable">
							
						</tbody>
						<tr>
							<th></th>
							<th style=" font-size: 14px;"><strong>Total</strong></th>
							<th style=" font-size: 14px;"><strong class="s_grandTotal"></strong></th>
							<th style=" font-size: 14px;"><strong class="d_grandTotal"></strong></th>
							<th style=" font-size: 14px;"><strong class="c_grandTotal"></strong></th>
							<th style=" font-size: 14px;"><strong class="p_grandTotal"></strong></th>
						</tr>
					</table>
				</div><!-- /.table-responsive -->
			</div>	
		</div><!-- /col-md-12 -->
	</div>
		

	<div class="voucher printPirnter" style="visibility:hidden;">
		<div class="col-md-12"><img alt="logo" src="{{ asset('assets/header-logo.png')}}"></div>
			<table  class="border" cellpadding="1" cellspacing="1" style="text-align:center;width:700px;margin-left:auto;margin-right:auto;font-size: 10px; font-weight: bold;font-family: helvetica;  ">
				<tr>
					<tr>
						<th colspan="4" style="text-align:center;text-transform:uppercase;"><strong class="movieName"></strong></th>
					</tr>
					<th style="width:175px;text-align:center;"><strong>Report Date</strong></th>
					<th style="width:175px;text-align:center;"><strong class="repDate"></strong></th>
					
					<th style="width:175px;text-align:center;"><strong>Current Time</strong></th>
					<th style="width:175px;text-align:center;"><strong class="c_date"></strong></th>
				</tr>


			</table>
			<div class="border" style="margin-top:5px;"></div>
			<table  class=" border" cellpadding="1" cellspacing="1" style="text-align:center;width:700px;margin:auto;font-size: 10px; font-weight: bold;font-family: helvetica; ">
				<thead>
					<tr>
						<td>Showtime </td>
						<td>Screen </td>
						<td>Qty</td>
						<td>Deal Qty</td>
						<td>Complimentary Qty</td>
						<td>Price</td>
					</tr>
				</thead>
				<tbody class="searchable">
					
				</tbody>
				<tr>
					<th></th>
					<th style=" font-size: 14px;text-align:center;"><strong>Total</strong></th>
					<th style=" font-size: 14px; text-align: center;"><strong class="s_grandTotal"></strong></th>
					<th style=" font-size: 14px; text-align: center;"><strong class="d_grandTotal"></strong></th>
					<th style=" font-size: 14px; text-align: center;"><strong class="c_grandTotal"></strong></th>
					<th style=" font-size: 14px; text-align: center;"><strong class="p_grandTotal"></strong></th>
				</tr>
			</table>
		
		<div class="voucher printPirnter border" style="margin-top:5px;"></div>	
	</div>
</div><!-- Container Close -->

@endsection

@section('scripts')
	
	<script type="text/javascript">
		

		$(document).ready(function(){
			//$('.admin-table').hide();
			$('.save-button').on('click', function(){
				var date = $('.goDate').val();
				var id = $('.goMovie').val();
				$('#hack').show();
				$.ajax({
	                url: baseUrl+'/ticketSalesByMovieReq',
	                method:'POST',
	                dataType:'json',
	                data:{'id':id, 'date' : date , '_token': '{{csrf_token()}}'},
	                success: function (record) {
	                	console.log(record);
						$('.admin-table').show();
						$('.searchable').html('');
						$('.grandTotal').html('');

						var s_grandTotal = 0;
						var p_grandTotal = 0;
						var c_grandTotal = 0;
						var d_grandTotal = 0;
						var html = '';
						$('.movieName').html(record.movie);

						if(record.time.length>0){
							$('.repDate').text(record.created_at);
							$('.c_date').text(record.now);
						}
						if(record.time.length>0){
							for(var i=0; i<record.time.length; i++){
								html += `
									<tr>
										<td>`+record.time[i]+`</td>
										<td>`+record.screens[i]+`</td>
										<td>`+record.qty[i]+`</td>
										<td>`+record.deal[i]+`</td>
										<td>`+record.isComp[i]+`</td>
										<td>`+record.price[i]+`</td>
									</tr>
								`;
								s_grandTotal += record.qty[i];
								d_grandTotal += record.deal[i];
								c_grandTotal += record.isComp[i];
								p_grandTotal += record.price[i];
							}
						}

						$('.s_grandTotal').html(s_grandTotal);
						$('.d_grandTotal').html(d_grandTotal);
						$('.p_grandTotal').html(p_grandTotal);
						$('.c_grandTotal').html(c_grandTotal);
						$('.searchable').html(html);
	                	$('#hack').hide();
	                },
	            });
			});
		});
	</script>	

@endsection