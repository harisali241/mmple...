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
		  <li class="active">Advance Seats Booking by day</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm no-print"  action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Advance Seats Booking</h3>
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
								<th>Showtimes</th>
								@foreach($screens as $screen)
									<th>{{$screen->name}}</th>
								@endforeach
							</tr> 
						</thead>
				
						<tbody class="searchable">
							
						</tbody>
						<thead class="searchable2">
							
						</thead>
					</table>
					<h3 style="text-align: right;margin-right: 55px;" class="total-seats">Total Seats:  <span class="grandTotal"> 0</span></h3>
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
		
		<table class=" border" cellpadding="1" cellspacing="1" style="text-align:center;width:700px;margin:auto;font-size: 10px; font-weight: bold;font-family: helvetica; ">
			<thead>
				<tr> 
					<th>Showtimes</th>
					@foreach($screens as $screen)
						<th>{{$screen->name}}</th>
					@endforeach
				</tr> 
			</thead>
	
			<tbody class="searchable">
				
			</tbody>
			<thead class="searchable2">
				<tr> 
					<th>Screen Total</th>
					@foreach($screens as $screen)
						<th></th>
					@endforeach
				</tr> 
			</thead>
		</table>
		<div class="voucher printPirnter border" style="margin-top:5px;"></div>	
			<table class="voucher printPirnter border" cellpadding="1" cellspacing="1" style="width:700px;text-align:center;margin:auto;font-size: 10px; font-weight: bold;font-family: helvetica;  ">
				<tr>
					<th style="width:350px;text-align:center;">Total Seats: </th>
					<th style="width:350px;text-align:center;" class="grandTotal"></th>
				</tr>
			</table>
		</div>
	</div>
</div><!-- Container Close -->

@endsection

@section('scripts')
	
	<script type="text/javascript">
		

		$(document).ready(function(){
			$('.admin-table, .total-seats').hide();
			$('.save-button').on('click', function(){
				var date = $('.goDate').val();
				//console.log(date);
				//$('#hack').show();
				$.ajax({
	                url: '/advanceBookingByDayReq',
	                method:'POST',
	                dataType:'json',
	                data:{ 'date' : date , '_token': '{{csrf_token()}}'},
	                success: function (show) {
						$('.admin-table, .total-seats').show();
						$('.searchable').html('');
						$('.grandTotal').html('');
						//console.log(show);
						var grandTotal = 0;
						var html = '';
						var html2 = '';
						var html3 = '';

						if(show.created_at.length>0){
							$('.repDate').text(show.created_at);
							$('.c_date').text(show.now);
						}

						if(show.id.length>0){
							for(var i=0; i<show.id.length; i++){
								for(var z=0; z<show.screens.length; z++){
									if(show.id[i] == show.screens[z].id){
										html2+='<td align="center" class="ftotal'+show.screens[z].id+'">'+show.qty[i]+'</td>';
									}else{
										html2+='<td align="center">-</td>';
									}
								}
								html += `
									<tr>
										<td>`+show.show[i]+`</td>`+html2+`
									</tr>
								`;
								html2 = '';
							}
							html3 = `
								<tr> 
									<th>Screen Total</th>
									@foreach($screens as $screen)
										<th style="text-align:center;" class="totals{{$screen->id}}">0</th>
									@endforeach
								</tr> 
							`;
						}
						
						$('.searchable').html(html);
						$('.searchable2').html(html3);
						var addto = 0;
						var tothis = 0;
						var garb = [];
						for(var y=0; y<show.id.length; y++){
							if(garb.indexOf(show.id[y]) > -1){
								garb.push(show.id[y]);
							}else{
								$('.searchable .ftotal'+show.id[y]).each(function() {
									addto += +$(this).text();
								});
							}
							$('.totals'+show.id[y]).text(addto/2);
							grandTotal += addto/2;
							addto = 0;
						}

						$('.grandTotal').html(grandTotal);
	                	$('#hack').hide();
	                },
	            });
			});
		});
	</script>	

@endsection