@extends('layouts.master')
@section('content')


<div class="container no-print">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li><a href="{{url('concessionReport')}}">Reports Concession</a></li>
		  <li class="active">Package Sales</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm"  action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Package Sales Details</h3>
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
				
		<div class="col-md-12">		
			<div class="col-md-4">	
				<div class="form-group">
					<label for="" class="col-sm-4 control-label"><span>*</span> From Date: </label>
					<div class="col-sm-8">
						<input type="text" name="goRecord" id="" value="" class="form-control date_pp goRecord" required autocomplete="off">
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
							<th>No.</th>
							<th>Transaction Time</th>
							<th>Package Id</th>
							<th>Package Name</th>
							<th>Qty</th>
							<th>Deal</th>
							<th>Price</th>
							<th>Sales</th>
						</thead>
						<tbody class="searchable">
						
						</tbody>
						<tr> 
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td style=" font-size: 14px;"><strong>Total</strong></td>
							<td style=" font-size: 14px;"><strong class="grandTotal"></strong></td>
						</tr> 
					</table>
				</div><!-- /.table-responsive -->
			</div>	
		</div><!-- /col-md-12 -->
	</div><!-- Container Close -->
</div>
<style>
@media print {
  .printPirnter {
    display: block !important; 
  }
}
</style>

	<div class="voucher printPirnter" style="visibility:hidden;">	
		<table  class="border" cellpadding="1" cellspacing="1" style="text-align:center;width:700px;margin-left:auto;margin-right:auto;font-size: 10px; font-weight: bold;font-family: helvetica;  ">
			<thead>	
				<tr> 
					<th colspan='4'  style="text-align:center;"><strong>Item Sale</strong></th>
				</tr>
				<tr> 
					<th colspan='2'  style="text-align:center;" ><strong>Report date : </strong><strong class="repDate"></strong></th>
					<th colspan='2'  style="text-align:center;" ><strong>Current time : </strong><strong class="c_date"></strong></th>
				</tr> 
				<tr> 
					<td>Package Name</td>
					<td>Qty</td>
					<td>Price</td>
					<td>Sales</td>
				</tr> 
			</thead>
			<tbody class="p_searchable">
	
				
			</tbody>
				<tr> 
					<td></td>
					<td></td>
					<td style=" font-size: 14px;"><strong>Total</strong></td>
					<td style=" font-size: 14px;"><strong class="grandTotal"></strong></td>
				</tr> 
		</table>
	</div>
	
@endsection

@section('scripts')
	
	<script type="text/javascript">
		
		$('.save-button').on('click', function(){
			var date = $('.goRecord').val();
			$('#hack').show();
			$.ajax({
				url: 'packageSalesReq',
				method: 'post',
				dataType: 'json',
				data:{'date':date, '_token':'{{csrf_token()}}'},
				success: function(items){
					$('.searchable').html('');
					var html = '';
					var html2 = '';
					var count  = 1
					var grandTotal = 0;
					for(var i=0; i<items.length; i++){
						var date = new Date(items[i].created_at)
						var theDate = date.toDateString()+' ('+("0" + date.getHours()).slice(-2)+':'+("0" + date.getMinutes()).slice(-2)+')';

						if(items[i].concession_masters.deal_id != null){
							var itemType = JSON.parse(items[i].concession_masters.deals.type);
							var itemQty = JSON.parse(items[i].concession_masters.deals.qty);
							for (var x=0; x<itemType.length; x++) {
								if(itemType[x] == 'item'){
									//html2 = `<td align="center">`+itemQty[x]+`</td>`;
									html2 = `<td align="center">Deal</td>`;
								}
							}
						}else{
							html2 = `<td align="center">-</td>`;
						}

						html += `
							<tr>
								<td>`+count+`</td>
								<td>`+theDate+`</td>
								<td>`+items[i].package_id+`</td>
								<td>`+items[i].packages.name+`</td>
								<td>`+items[i].qty+`</td>`+html2+`
								<td>`+items[i].price+`</td>
								<td>`+items[i].amount+`</td>
							</tr>
						`;
						grandTotal += +items[i].amount;
						count++;
					}
					$('.searchable').html(html);
					

					phtml = '';
					var pdate = new Date(date)
					$('.repDate').text(pdate.toDateString());

					var pcdate = new Date()
					$('.c_date').text(pcdate.toDateString())
					$('.p_searchable').html('');
					var oneitem = [];
					var oneqty = [];
					var oneprice = [];
					for(var i=0; i<items.length; i++){
						if(oneitem.indexOf(items[i].packages.name) > -1){
							oneqty[oneitem.indexOf(items[i].packages.name)] += items[i].qty;
						}else{
							oneitem.push(items[i].packages.name);
							oneqty.push(items[i].qty);
							oneprice.push(items[i].price);
						}
					}

					for(var x=0; x<oneitem.length; x++){

						phtml += `
							<tr>
								<td>`+oneitem[x]+`</td>
								<td>`+oneqty[x]+`</td>
								<td>`+oneprice[x]+`</td>
								<td>`+oneqty[x]*oneprice[x]+`</td>
							</tr>
						`;
					}
					
					$('.p_searchable').html(phtml);
					$('.grandTotal').text(grandTotal);
					$('#hack').hide();
				}
			});

		});

	</script>

@endsection