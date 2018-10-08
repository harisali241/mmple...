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
		  <li class="active">Current Seats bookings by day</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm no-print"  action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Seats bookings by day</h3>
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
								<th style=" font-size: 14px;"></th>
								<th style=" font-size: 14px;"></th>
								<th style=" font-size: 14px;"><strong>Current time : </strong><strong class="c_date"></strong></th>
							</tr> 
							<tr> 
								<td>Screens </td>
								<td>1st </td>
								<td>2nd </td>
								<td>3rd </td>
								<td>4th </td>
								<td>5th </td>
								<td>Qty</td>
							</tr> 
						</thead>
				
						<tbody class="searchable">
							
						</tbody>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>Total</td>
								<td class="grandTotal"></td>
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
					<th colspan="7" style="width:140px;text-align:center;"><strong>Seats Booking by Day</strong></th>
				</tr>
				<th colspan="2" style="width:140px;text-align:center;"><strong>Report Date</strong></th>
				<th colspan="2" style="width:140px;text-align:center;"><strong class="repDate"></strong></th>
				<th colspan="2" style="width:140px;text-align:center;"><strong>Current time : </strong></th>
				<th style="width:140px;text-align:center;"><strong class="c_date"></strong></th>
			</tr>
		</table>
		<div class="border" style="margin-top:5px;"></div>				
		
		<table  class=" border" cellpadding="1" cellspacing="1" style="text-align:center;width:700px;margin:auto;font-size: 10px; font-weight: bold;font-family: helvetica; ">
			<thead>
				<tr> 
					<td>Screens </td>
					<td>1st </td>
					<td>2nd </td>
					<td>3rd </td>
					<td>4th </td>
					<td>5th </td>
					<td>Qty</td>					
				</tr>
			</thead>
			<tbody class="searchable">

			</tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Total</td>
					<td class="grandTotal"></td>
				</tr>
		</table>
		
		<div class="voucher printPirnter border" style="margin-top:5px;"></div>	
	</div>
</div><!-- Container Close -->

@endsection

@section('scripts')
	
	<script type="text/javascript">
		

		$(document).ready(function(){
			$('.admin-table').hide();
			$('.save-button').on('click', function(){
				var date = $('.goDate').val();
				//console.log(date);
				$('#hack').show();
				$.ajax({
	                url: baseUrl+'/totalSeatBookingByDayReq',
	                method:'POST',
	                dataType:'json',
	                data:{ 'date' : date , '_token': '{{csrf_token()}}'},
	                success: function (seats) {
						$('.admin-table').show();
						$('.searchable').html('');
						$('.grandTotal').html('');
						//console.log(seats);
						var grandTotal = 0;
						var html = '';
						var html2 = '';

						if(seats.screen.length>0){
							$('.repDate').text(seats.created_at);
							$('.c_date').text(seats.now);
						}

						for(var i=0; i<seats.screen.length; i++){
							if(seats.screen.length>0){
								for (var z=0; z<seats.time[i].length; z++) {
									html2 += `<td align="center">`+seats.time[i][z]+`<br>Seats: `+seats.seatPerShow[i][z]+`<br>`+seats.movie[i][z]+`</td>`;
								}
								var dash = 5 - seats.time[i].length
								for (var y=0; y<dash; y++) {
									html2 += `<td align="center">-</td>`;
								}
								html += `
								<tr>
									<td align="center">`+seats.screen[i]+`</td>`+html2+`<td>`+seats.qty[i]+`</td>
								</tr>
								`;
								grandTotal += +seats.qty[i];
								var html2 = '';
							}
						}
						$('.grandTotal').html(grandTotal);
						$('.searchable').html(html);
	                	$('#hack').hide();
	                },
	            });
			});
		});
	</script>	

@endsection