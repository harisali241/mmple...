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
		  <li class="active">Ticket Sale By User</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm no-print"  action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Ticket Sale By User</h3>
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
		<br>
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

		<div class="col-md-6">
			<br>	
			<div class="col-md-12 t_select">
				<div class="form-group">
					<label for="" class="col-sm-4 control-label"><span>* </span> Select User: </label>
					<div class="col-sm-8">
						<select class="form-control goUser" required>
							<option value=""  selected disabled >Select User</option>
							@foreach ($users as $user)
								<option value="{{$user->id}}">{{$user->firstName}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>

		</div><!-- col-md-6 -->

		<div class="col-md-6">
			<br>	
			<div class="col-md-12 t_select">
				<div class="form-group">
					<label for="" class="col-sm-4 control-label"><span>* </span> Select Movie: </label>
					<div class="col-sm-8">
						<select class="form-control goMovie" required>
							<option value="" selected>All Movie</option>
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
								<th style="text-align:center;border-bottom:solid 1px gray;" colspan="6" class="username"></th>
							</tr>
							<tr>
								<th  style="text-align:center;">Movie</th>
								<th  style="text-align:center;">Deal Tickets</th>
								<th  style="text-align:center;">Paid Tickets</th>
								<th  style="text-align:center;">Complimentary Tickets</th>
								<th  style="text-align:center;">Total Tickets</th>
								<th  style="text-align:center;">Final Cash</th>
							</tr>
						</thead>
						<tbody class="searchable">
							  
						</tbody>
						<tr>
							<th style="text-align:center;">Total</th>
							<th style="text-align:center;" class="d_total">0</th>
							<th style="text-align:center;" class="p_total">0</th>
							<th style="text-align:center;" class="c_total">0</th>
							<th style="text-align:center;" class="t_total">0</th>
							<th style="text-align:center;" class="grandTotal">0</th>
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
					<th style="text-align:center;" colspan="4"><strong class="username"></strong></th>
				</tr>
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
						<th  style="text-align:center;">Movie</th>
						<th  style="text-align:center;">Deal Tickets</th>
						<th  style="text-align:center;">Paid Tickets</th>
						<th  style="text-align:center;">Complimentary Tickets</th>
						<th  style="text-align:center;">Total Tickets</th>
						<th  style="text-align:center;">Final Cash</th>
					</tr>
				</thead>
				<tbody class="searchable">
					
				</tbody>
				<tr>
					<th style="text-align:center;">Total</th>
					<th style="text-align:center;" class="d_total">0</th>
					<th style="text-align:center;" class="p_total">0</th>
					<th style="text-align:center;" class="c_total">0</th>
					<th style="text-align:center;" class="t_total">0</th>
					<th style="text-align:center;" class="grandTotal">0</th>
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
				var movie_id = $('.goMovie').val();
				var user_id = $('.goUser').val();

				$('#hack').show();
				$.ajax({
	                url: baseUrl+'/ticketSalesByUserReq',
	                method:'POST',
	                dataType:'json',
	                data:{'startDate':startDate, 'endDate':endDate, 'movie_id':movie_id, 'user_id' : user_id , '_token': '{{csrf_token()}}'},
	                success: function (data) {
	                	//console.log(data);
						$('.admin-table').show();
						$('.searchable').html('');
						$('.d_total').html(0);
						$('.p_total').html(0);
						$('.c_total').html(0);
						$('.t_total').html(0);
						$('.grandTotal').html(0);

						var grandTotal = 0;
						var d_total = 0;
						var p_total = 0;
						var c_total = 0;
						var t_total = 0;
						var html = '';

						if(data.movie.length>0){
							$('.repStartDate').text(data.startDate);
							$('.repEndDate').text(data.endDate);
						}
						if(data.movie.length>0){
							for(var x=0; x<data.movie.length; x++){
								html += `
									<tr>
										<td style="text-align:center;vertical-align:middle;">`+data.movie[x]+`</td>
										<td style="text-align:center;vertical-align:middle;">
											<span>Qty: `+data.qtyNprice.deal_qty[x]+`</span><br>
											<span>Price: `+data.qtyNprice.deal_price[x]+`</span>
										</td>
										<td style="text-align:center;vertical-align:middle;">
											<span>Qty: `+(data.qtyNprice.qty[x]-data.qtyNprice.deal_qty[x]-data.qtyNprice.comp_qty[x])+`</span><br>
											<span>Price: `+(data.qtyNprice.price[x])+`</span>
										</td>
										<td style="text-align:center;vertical-align:middle;">
											<span>Qty: `+data.qtyNprice.comp_qty[x]+`</span><br>
											<span>Price: `+data.qtyNprice.comp_price[x]+`</span>
										</td>
										<td style="text-align:center;vertical-align:middle;">
											<span>Qty: `+data.qtyNprice.qty[x]+`</span><br>
											<span>Price: `+(+data.qtyNprice.price[x] + +data.qtyNprice.comp_price[x] + +data.qtyNprice.deal_price[x])+`</span>
										</td>
										<td style="text-align:center;vertical-align:middle;">`+(data.qtyNprice.price[x])+`</td>
									</tr>
								`;
								grandTotal += (data.qtyNprice.price[x]);
								d_total += data.qtyNprice.deal_price[x];
								p_total += (data.qtyNprice.price[x]);
								c_total += data.qtyNprice.comp_price[x];
								t_total += +data.qtyNprice.price[x] + +data.qtyNprice.deal_price[x] + +data.qtyNprice.comp_price[x];
							}
						}

						$('.username').text(data.userName);
						$('.d_total').html(d_total);
						$('.p_total').html(p_total);
						$('.c_total').html(c_total);
						$('.t_total').html(t_total);
						$('.grandTotal').html(grandTotal);
						$('.searchable').html(html);
	                	$('#hack').hide();
	                },
	            });
			});
		});
	</script>	

@endsection