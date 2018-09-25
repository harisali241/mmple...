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
		  <li class="active">Cash in hand</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm no-print"  action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Cash in hand</h3>
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
								<th>Users</th>
								<th>Screen</th>
								<th>Total tickets</th>
								<th>Cash</th>
							</tr>
						</thead>
						<tbody class="searchable">
							  
						</tbody>
					</table>
					<h3 style="text-align: right;margin-right: 55px;">Total Cash: <span class="grandTotal">0</span></h3>
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
						<th style="text-align:center;">Users</th>
						<th style="text-align:center;">Screen</th>
						<th style="text-align:center;">Total tickets</th>
						<th style="text-align:center;">Cash</th>
					</tr>
				</thead>
				<tbody class="searchable">
					
				</tbody>
			</table>
			<h3 style="text-align: right;margin-right: 55px;">Total Cash: <span class="grandTotal">0</span></h3>
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
				var id = $('.goMovie').val();
				$('#hack').show();
				$.ajax({
	                url: '/cashInHandByDayReq',
	                method:'POST',
	                dataType:'json',
	                data:{'id':id, 'date' : date , '_token': '{{csrf_token()}}'},
	                success: function (data) {
	                	var record = data.record;
	                	//console.log(record);
						$('.admin-table').show();
						$('.searchable').html('');
						$('.grandTotal').html('');
						//console.log(seats);
						var grandTotal = 0;
						var html = '';

						if(record.length>0){
							$('.repDate').text(data.date);
							$('.c_date').text(data.now);
						}
						if(record.length>0){
							for(var i=0; i<record.length; i++){
								for(var x=0; x<record[i].screen.length; x++){
									html += `
									<tr>
										<td>`+record[i].name[0]+`</td>
										<td>`+record[i].screen[x]+`</td>
										<td>`+record[i].qty[x]+`</td>
										<td>`+record[i].price[x]+`</td>
									</tr>
									`;
									grandTotal += record[i].price[x];
								}
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