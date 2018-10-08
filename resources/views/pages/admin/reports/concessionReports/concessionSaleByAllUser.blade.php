@extends('layouts.master')
@section('content')

<div class="container no-print">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="index.php">Home</a></li>
		  <li><a href="{{url('/concessionReport')}}">Reports Concession</a></li>
		  <li class="active">Cash in hand</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm"  action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Concession Sale Cash in Hand</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" onclick="window.print()">Print</button>
				 		<button type="button" class="btn submitBtn save-button">Generate Report</button> 		
			 		</div>
			 	</div>
		 	</div>
		</div><!--row-->
	</form>
	<div class="form-container">
				
		<div class="col-md-6">
			<div class="col-md-12">	
				<div class="form-group">
					<label for="" class="col-sm-4 control-label"><span>*</span> Start Date: </label>
					<div class="col-sm-8">
						<input type="text" value="" class="form-control date_pp goDate" >
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div><!-- col-md-6 -->

		<div class="col-md-6"></div><!-- col-md-6 -->

		<div class="col-md-12">
			<div class="the-box full no-border">
				<div class="table-responsive">

					<table border="1" cellpadding="0" cellspacing="0" class="table table-hover tableView admin-table" style="    font-size: 12px; font-weight: bold;font-family: helvetica;">
						<tr>
							<th>User</th>
							<th>Total Cash</th>
						</tr>
						<tbody class="searchable">
							
						</tbody>
					      
					</table>
				
					<h3 style="text-align: right;margin-right: 55px;">Total Cash: <span class="grandTotal">0</span></h3>
				</div><!-- /.table-responsive -->
			</div>	
		</div><!-- /col-md-12 -->
	</div><!-- Container Close -->
</div><!-- Container Close -->
	

<div class="voucher printPirnter" style="visibility:hidden;">
	<table  class="border" cellpadding="1" cellspacing="1" style="text-align:center;width:700px;margin-left:auto;margin-right:auto;font-size: 10px; font-weight: bold;font-family: helvetica;  ">
		<tr> 
			<th style="width:175px;text-align:center;"><strong>Report day</strong></th>
			<th style="width:175px;text-align:center;"><strong class="repDate"></strong></th>
			
			<th style="width:175px;text-align:center;"><strong>Current Time: </strong></th>
			<th style="width:175px;text-align:center;"><strong class="c_date"></strong></th>
		</tr>
	</table>
	<div class="border" style="margin-top:5px;"></div>				
	
	<div class="table-responsive">
		<table  class="border" cellpadding="1" cellspacing="1" style="text-align:center;width:700px;margin-left:auto;margin-right:auto;font-size: 10px; font-weight: bold;font-family: helvetica;  ">
			<tr>
				<th style="text-align:Center;">Users</th>
				<th style="text-align:Center;">Cash</th>
			</tr>
			<tbody class="searchable">
				
			</tbody>
		</table>
	</div>
	<div class="voucher printPirnter border" style="margin-top:5px;"></div>	

	<table class="voucher printPirnter border" cellpadding="1" cellspacing="1" style="width:700px;text-align:center;margin:auto;font-size: 10px; font-weight: bold;font-family: helvetica;  ">
		<tr>
			<th style="width:350px;text-align:center;">Total Cash: </th>
			<th style="width:350px;text-align:center;" class="grandTotal"></th>
		</tr>
	</table>
</div>
@endsection

@section('scripts')

	<script type="text/javascript">
		
		$('.save-button').on('click', function(){
			var date = $('.goDate').val();
			$('#hack').show();
			$.ajax({
				url: baseUrl+'concessionSaleByAllUserReq',
				method: 'post',
				dataType: 'json',
				data:{'date':date, '_token':'{{csrf_token()}}'},
				success: function(items){
					$('.searchable').html('');
					$('.grandTotal').text(0);
					html = '';
					var count  = 1
					var grandTotal = 0;
					if(items.length>0){
						var pdate = new Date(items[0].created_at)
						$('.repDate').text(pdate.toDateString());

						var pcdate = new Date()
						$('.c_date').text(pcdate.toDateString())
						var oneitem = [];
						var oneqty = [];
						for(var i=0; i<items.length; i++){
							if(oneitem.indexOf(items[i].users.username) > -1){
								oneqty[oneitem.indexOf(items[i].users.username)] += items[i].totalAmount;
							}else{
								oneitem.push(items[i].users.username);
								oneqty.push(items[i].totalAmount);
							}
						}
						for(var x=0; x<oneitem.length; x++){
							html += `
								<tr>
									<td>`+oneitem[x]+`</td>
									<td>`+oneqty[x]+`</td>
								</tr>
							`;
							grandTotal += oneqty[x];
						}
						
						$('.searchable').html(html);
						$('.grandTotal').text(grandTotal);
					}
					
					$('#hack').hide();
				}
			});

		});

	</script>

@endsection