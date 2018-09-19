@extends('layouts.master')
@section('content')


<div class="container no-print">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li><a href="{{url('concessionReport')}}">Reports Concession</a></li>
		  <li class="active">Single Package Sales</li>
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
					<label for="" class="col-sm-4 control-label"><span>*</span> Date: </label>
					<div class="col-sm-8">
						<input type="text" class="form-control date_pp goDate" required autocomplete="off">
					</div>
				</div>
			</div>

			<div class="col-md-4">	
				<div class="form-group">
					<label for="" class="col-sm-4 control-label"><span>*</span> Package: </label>
					<div class="col-sm-8">
						<select class="form-control goPackage" required>
							<option value="" selected disabled>Select Package</option>
							@foreach ($packages as $package)
								<option value="{{$package->id}}">{{$package->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div><!-- col-md-6 -->

		<div class="col-md-6"></div><!-- col-md-6 -->
			
		<div class="col-md-12">
			<div class="the-box full no-border">
				<div class="table-responsive">
					<table border="1" cellpadding="0" cellspacing="0" id="example" class="table table-hover tableView admin-table" style="font-size: 12px; font-weight: bold;font-family: helvetica;">
						<thead>
							<tr> 
								<th style=" font-size: 14px;"><strong>Report time</strong></th>
								<th style=" font-size: 14px;"><strong class="repDate"></strong></th>
								<th style=" font-size: 14px;"><strong>Current time : </strong></th>
								<th style=" font-size: 14px;"><strong class="c_date"></strong></th>
							</tr> 

							<tr> 
								<td>No.</td>
								<td>Package Name</td>
								<td>Qty</td>
								<td>Price</td>
							</tr> 
						</thead>
						<tbody class="searchable">
						
						</tbody>
						<tr> 
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
					<th colspan='4'  style="text-align:center;"><strong>Package Sale</strong></th>
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
			var date = $('.goDate').val();
			var id = $('.goPackage').val();
			if(date != null && id != null){
				$('#hack').show();
				$.ajax({
					url: 'singlePackageSalesReq',
					method: 'post',
					dataType: 'json',
					data:{'date':date, 'id':id, '_token':'{{csrf_token()}}'},
					success: function(items){
						$('.searchable').html('');
						$('.p_searchable').html('');
						html = '';
						var grandTotal = 0;
						
						if(items.length>0){
							var pdate = new Date(items[0].created_at).toDateString();
							$('.repDate').text(pdate);
						}

						var pcdate = new Date()
						$('.c_date').text(pcdate.toDateString())

						var oneitem = [];
						var oneqty = [];
						var oneprice = [];
						var count = 1;
						for(var i=0; i<items.length; i++){
							if(oneitem.indexOf(items[i].packages.name) > -1){
								oneqty[oneitem.indexOf(items[i].packages.name)] += items[i].qty;
							}else{
								oneitem.push(items[i].packages.name);
								oneqty.push(items[i].qty);
								oneprice.push(items[i].price);
							}
							grandTotal += +items[i].amount;
						}

						for(var x=0; x<oneitem.length; x++){
							html += `
								<tr>
									<td>`+oneitem[x]+`</td>
									<td>`+oneqty[x]+`</td>
									<td>`+oneprice[x]+`</td>
									<td>`+oneqty[x]*oneprice[x]+`</td>
								</tr>
							`;
							count++;
						}
						
						$('.searchable').html(html);
						$('.p_searchable').html(html);
						$('.grandTotal').text(grandTotal);
						$('#hack').hide();
					}
				});
			}
			

		});

	</script>

@endsection