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
		  <li class="active">Deals Ticket</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm no-print"  action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Deals Ticket</h3>
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
		<div class="col-sm-12">
			<div class="col-sm-5">	
				<div class="form-group">
					<label for="" class="col-sm-3 control-label"><span>*</span> From Date: </label>
					<div class="col-sm-9">
						<input type="text" name="startDate" value="" class="form-control datetimepicker goStartDate" required autocomplete="off">
					</div>
				</div>
			</div>

			<div class="col-sm-5">	
				<div class="form-group">
					<label for="" class="col-sm-3 control-label"><span>*</span> To Date: </label>
					<div class="col-sm-9">
						<input type="text" name="endDate" value="" class="form-control datetimepicker goEndDate" required autocomplete="off">
					</div>
				</div>
			</div>
		</div>

		<br><br><br>

		<div class="col-sm-12 t_select" id="showtime_movie_id">
			<div class="form-group">
				
				<div class="col-md-4" style="margin-bottom:10px;">
					<label for="showtime_movie_id" class="col-sm-4 control-label"><span>* </span> Show Users: </label>
					<div class="col-sm-8"  style="margin-bottom:10px;">
						<select class="form-control goUser" required>
							<option value="" disabled selected>Select Users</option>
							@foreach($users as $user)
								<option value="{{$user->id}}">{{$user->firstName}}</option>
							@endforeach
						</select>
					</div>
				</div>

			</div>
		</div>

	
		<div class="col-md-12 no-print">
			<div class="the-box full no-border">
				<div class="table-responsive">
					<table border="1" cellpadding="0" cellspacing="0" id="example" class="table table-hover tableView admin-table" style=" font-size: 12px; font-weight: bold;font-family: helvetica;">
						<thead>
							<tr>
								<th>Deal Name</th>
								<th>User</th>
								<th>Deal Ticket</th>
								<th>Cash</th>
								{{-- <th>Total Ticket</th> --}}
							</tr>
						</thead>
						<tbody class="searchable">
							
						</tbody>
						<tr>
							<th style=" font-size: 14px;text-align: center;" colspan="2"><strong>Total</strong></th>
							<th style=" font-size: 14px;"><strong class="d_grandTotal"></strong></th>
							<th style=" font-size: 14px;"><strong class="p_grandTotal"></strong></th>
							{{-- <th style=" font-size: 14px;"><strong class="t_grandTotal"></strong></th> --}}
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
					<th style="width:175px;text-align:center;"><strong>Report Date</strong></th>
					<th style="width:175px;text-align:center;">
						<strong>From : </strong><strong class="repStartDate"></strong><br>
						<strong>To : </strong><strong class="repEndDate"></strong>
					</th>

					<th style="width:175px;text-align:center;"><strong>Current Time</strong></th>
					<th style="width:175px;text-align:center;"><strong class="c_date">{{date('Y-m-d h:i a')}}</strong></th>
				</tr>


			</table>
			<div class="border" style="margin-top:5px;"></div>
			<table  class=" border" cellpadding="1" cellspacing="1" style="text-align:center;width:700px;margin:auto;font-size: 10px; font-weight: bold;font-family: helvetica; ">
				<thead>
					<tr>
						<th style="text-align: center;">Deal Name</th>
						<th style="text-align: center;">User</th>
						<th style="text-align: center;">Deal Ticket</th>
						<th style="text-align: center;">Cash</th>
					</tr>
				</thead>
				<tbody class="searchable">
					
				</tbody>
				<tr>
					<th style=" font-size: 14px;text-align: center;" colspan="2"><strong>Total</strong></th>
					<th style=" font-size: 14px;text-align: center;"><strong class="d_grandTotal"></strong></th>
					<th style=" font-size: 14px;text-align: center;"><strong class="p_grandTotal"></strong></th>
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
				var startDate = $('.goStartDate').val();
				var endDate = $('.goEndDate').val();
				var id = $('.goUser').val();
				$('#hack').show();
				$.ajax({
	                url: '/dealReportReq',
	                method:'POST',
	                dataType:'json',
	                data:{ 'id':id, 'startDate' : startDate , 'endDate' : endDate , '_token': '{{csrf_token()}}'},
	                success: function (record) {
	                	console.log(record);
						$('.admin-table').show();
						$('.searchable').html('');
						$('.d_grandTotal').text('');
						$('.p_grandTotal').text('');
						//$('.t_grandTotal').text('');

						var d_grandTotal = 0;
						var p_grandTotal = 0;
						//var t_grandTotal = 0;
						var html = '';

						if(record.name.length>0){
							$('.repStartDate').text(record.startDate);
							$('.repEndDate').text(record.endDate);
						}
						if(record.name.length>0){
							for(var i=0; i<record.name.length; i++){
								html += `
									<tr>
										<td>`+record.name[i]+`</td>
										<td>`+record.username[i]+`</td>
										<td>`+record.dealQty[i]+`</td>
										<td>`+record.dealPrice[i]+`</td>
									</tr>									
								`;
								d_grandTotal += record.dealQty[i];
								p_grandTotal += record.dealPrice[i];
								//t_grandTotal += record.totalQty;
							}
						}

						$('.d_grandTotal').text(d_grandTotal);
						$('.p_grandTotal').text(p_grandTotal);
						//$('.t_grandTotal').text(t_grandTotal);
						$('.searchable').html(html);
	                	$('#hack').hide();
	                },
	            });
			});
		});
	</script>	

@endsection