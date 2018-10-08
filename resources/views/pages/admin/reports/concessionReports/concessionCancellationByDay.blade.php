@extends('layouts.master')
@section('content')

<div class="container no-print">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="index.php">Home</a></li>
		  <li><a href="{{url('/concessionReport')}}">Reports Concession</a></li>
		  <li class="active">Concession Cancellation by day</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm"  action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Concession Cancellation</h3>
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
			<div class="col-md-12">	
				<div class="form-group">
					<label for="" class="col-sm-4 control-label"><span>*</span>  Date: </label>
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
					<table border="1" cellpadding="0" cellspacing="0" id="example" class="table table-hover tableView admin-table" style="    font-size: 12px; font-weight: bold;font-family: helvetica;">
						
						<thead>
							<tr> 
								<th style=" font-size: 14px;"></th>
								<th style=" font-size: 14px;"></th>
								<th style=" font-size: 14px;"></th>
								<th style=" font-size: 14px;"></th>
								<th style=" font-size: 14px;"><strong>Current time : </strong></th>
								<th style=" font-size: 14px;"><strong class="c_date"></strong></th>
							</tr> 
							<tr> 
								<td>Cancelled by </td>
								<td>Cancelled Date </td>
								<td>Order Id </td>
								<td>Remarks </td>
								<td>Order Amount </td>
								<td>Booked date time</td>
							</tr> 
						
						</thead>
						<tbody class="searchable">
						   	
							
						</tbody>
							<tr> 
								<th style=" font-size: 14px;"></th>
								<th style=" font-size: 14px;"></th>
								<th style=" font-size: 14px;"></th>
								<th></th>
								<th style=" font-size: 14px;"><strong>Total</strong></th>
								<th style=" font-size: 14px;"><strong class="grandTotal"></strong></th>
							</tr> 
					</table>
				</div><!-- /.table-responsive -->
			</div>	
		</div><!-- /col-md-12 -->
		
	</div>	
</div><!-- Container Close -->

<div class="voucher printPirnter" style="visibility:hidden;">
	<table  class="border" cellpadding="1" cellspacing="1" style="text-align:center;width:700px;margin-left:auto;margin-right:auto;font-size: 10px; font-weight: bold;font-family: helvetica;  ">
		<tr> 
			<th style="width:175px;text-align:center;"><strong>Report Day: </strong></th>
			<th style="width:175px;text-align:center;"><strong class="repDate"></strong></th>
			<th style="width:175px;text-align:center;"><strong>Current time :</strong></th>
			<th style="width:175px;text-align:center;"><strong class="c_date"></strong></th>
		</tr>
	</table>
	<div class="border" style="margin-top:5px;"></div>				
		
	<table  class=" border" cellpadding="1" cellspacing="1" style="text-align:center;width:700px;margin:auto;font-size: 10px; font-weight: bold;font-family: helvetica; ">
		<thead>
			<tr> 
				<td>Cancelled by </td>
				<td>Cancelled Date </td>
				<td>Order Id </td>
				<td>Order Amount </td>
			</tr> 
		</thead>
				
		<tbody class="p_searchable">
			
		</tbody>
			<tr>
				<th></th>
				<th></th>
				<th style=" font-size: 14px;text-align:center;"><strong>Total</strong></th>
				<th style=" font-size: 14px;text-align:center;"><strong class="grandTotal"></strong></th>
			</tr> 
	</table>

	<div class="voucher printPirnter border" style="margin-top:5px;"></div>	
</div>

@endsection
@section('scripts')
	
	<script type="text/javascript">
		
		$('.save-button').on('click', function(){
			var date = $('.goDate').val();
			$('#hack').show();
			$.ajax({
				url: baseUrl+'concessionCancellationByDayReq',
				method: 'post',
				dataType: 'json',
				data:{'date':date, '_token':'{{csrf_token()}}'},
				success: function(items){
					$('.searchable').html('');
					html = '';
					var count  = 1
					var grandTotal = 0;

					if(items.length>0){
						for(var i=0; i<items.length; i++){
							var date = new Date(items[i].cancelDate)
							var theDate = date.toDateString()+' ('+("0" + date.getHours()).slice(-2)+':'+("0" + date.getMinutes()).slice(-2)+')';
							var dateca = new Date(items[i].created_at)
							var theDateca = dateca.toDateString()+' ('+("0" + dateca.getHours()).slice(-2)+':'+("0" + dateca.getMinutes()).slice(-2)+')';
							html += `
								<tr>
									<td>`+items[i].users.username+`</td>
									<td>`+theDate+`</td>
									<td>`+items[i].id+`</td>
									<td>`+items[i].remarks+`</td>
									<td>`+items[i].totalAmount+`</td>
									<td>`+theDateca+`</td>
								</tr>
							`;
							grandTotal += +items[i].totalAmount;
							count++;
						}
						$('.searchable').html(html);
						

						phtml = '';
						var pdate = new Date(date)
						$('.repDate').text(pdate.toDateString());

						var pcdate = new Date()
						$('.c_date').text(pcdate.toDateString()+' ('+("0" + date.getHours()).slice(-2)+':'+("0" + date.getMinutes()).slice(-2)+')');
						$('.p_searchable').html('');

						for(var x=0; x<items.length; x++){
							var date = new Date(items[x].cancelDate)
							var theDate = date.toDateString()+' ('+("0" + date.getHours()).slice(-2)+':'+("0" + date.getMinutes()).slice(-2)+')';
							phtml += `
								<tr>	
									<td>`+items[x].users.username+`</td>
									<td>`+theDate+`</td>
									<td>`+items[x].id+`</td>
									<td>`+items[x].totalAmount+`</td>
								</tr>
							`;
						}
						
						$('.p_searchable').html(phtml);
						$('.grandTotal').text(grandTotal);
					}
					$('#hack').hide();
				}
			});

		});

	</script>

@endsection