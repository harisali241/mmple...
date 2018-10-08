@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li class="active">Profit Or Loss</li>
		</ol>
	</div><!--row-->

<form class="form-horizontal dashboardForm"  action="" method="post">
	<div class="row gray-header">
		<div class="col-md-12">
			<div class="form-header-inner">
				<div class="col-sm-6">
					<h3>Profit Or Loss</h3>
				</div>
		 		<div class="col-sm-6 action_btn">
		 			<button type="button" class="btn submitBtn cancel-button">Cancel</button>
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
					<input type="text" value="" class="form-control goStartDate date_p1" autocomplete="off" required>
				</div>
			</div>
		</div>

		<div class="col-md-4">	
			<div class="form-group">
				<label for="" class="col-sm-4 control-label"><span>*</span> To: </label>
				<div class="col-sm-8">
					<input type="text" value="" class="form-control goEndDate date_p1" autocomplete="off" required>
				</div>
			</div>
		</div>
		
		<div class="clear"></div>

	
	</div><!-- col-md-6 -->

	<div class="col-md-6"></div>

	<div class="col-md-12">
		<div class="the-box full no-border">
			<div class="table-responsive">
			
				<table border="1" cellpadding="0" cellspacing="0" id="example" class="table table-hover tableView admin-table" style="    font-size: 12px; font-weight: bold;font-family: helvetica;">
					<thead>
						<th>Particular</th>
						<th>Amount</th>
					</thead>
					<tbody class="searchable">

						<tr>
							<td>Concession Sales</td>	
							<td style=" padding-left: 15px!important;" class="concession"></td>
						</tr>
						<tr>
							<td>Ticket sales</td>	
							<td class="ticket"></td>
						</tr>
						<tr>
							<td>Expenses</td>	
							<td> - </td>
						</tr>
						<tr>
							<td>Salary Expense</td>	
							<td> - </td>
						</tr>
						<tr>
							<th>Total</th>
							<th style="padding-left: 20px!important;" class="grandTotal"></th>
						</tr>  

					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div>	
	</div><!-- /col-md-12 -->
</div>
</div>
@endsection
@section('scripts')
	
	<script type="text/javascript">
		

		$(document).ready(function(){
			//$('.admin-table').hide();
			$('.save-button').on('click', function(){
				var startDate = $('.goStartDate').val();
				var endDate = $('.goEndDate').val();
				
				//$('#hack').show();
				$.ajax({
	                url: baseUrl+'/profitNlossReq',
	                method:'POST',
	                dataType:'json',
	                data:{ 'startDate' : startDate , 'endDate':endDate, '_token': '{{csrf_token()}}'},
	                success: function (record) {
						// console.log(record);

						$('.admin-table').show();
						$('.concession').text('+ '+record.con);
						$('.ticket').text('+ '+record.ticket);
						$('.grandTotal').html(+record.con + +record.ticket);

	                	$('#hack').hide();
	                },
	            });
			});
		});
	</script>	

@endsection