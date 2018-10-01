@extends('layouts.t_master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('bookConcession')}}">Home</a></li>
		  <li class="active">Voucher Concession</li>
		</ol>
	</div><!--row-->

	<div class="row form-header">
		<div class="col-md-12">
			<div class="form-header-inner">
				<h3>Voucher Concession</h3>
				{{--  <div class="search-btn input-group">
					<input type="text" id="filter" class="form-control search-control" placeholder="Search for...">
						<span class="input-group-btn">
						<button class="btn btn-default search-btn" type="button"><img src="{{asset('assets/images/search-icon.png') }}"/></button>
					</span>
				</div> --}}
		 	</div>
	 	</div>
	</div><!--row-->

	<div class="col-sm-4"></div>
	<div class="col-sm-4">
	  	<div class="search-btn input-group">
			<input type="text" name="searchFilter" autocomplete="off" class="form-control search-control wordToSearch" placeholder="Enter Voucher No From Ticket ..." style="height: 50px;">
			<span class="input-group-btn">
				<button class="btn btn-default search-btn search-btn-ticket" type="button"><img  src="{{ asset('assets/images/search-icon.png') }}"/></button>
			</span>
		</div>
	</div>
	<div class="col-sm-4"></div>
	
	<div class="row">
		<div class="col-md-12">	
			<table border="1" id="example" cellpadding="0" cellspacing="0" class="table table-hover tableView admin-table">
				<thead>
					<tr>
						<th>Order Id</th>
						<th>VoucherNo</th>
						<th>Items</th>
						<th>Order time</th>
						<th>print</th>
					</tr>
				</thead>
				<tbody class="searchable">
					
				</tbody>
			</table>
		</div>
	</div><!-- Row Close -->

</div><!-- Container Close -->

	<div class="delete_confirm_modal modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
		  Confirm Delete?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default btn_yes" >Yes</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		</div>
	  </div>
	</div><!-- Modal -->
		

</div><!-- container -->
<br><br>
@endsection
@section('scripts')
<script type="text/javascript">

	$(document).ready(function(){
		$('.admin-table').hide();
	});
	

	$(".search-btn-ticket").on('click',function() {
		var id = $('.wordToSearch').val();
		if(id != ''){
			$.ajax({
				url: 'voucherRecord',
				method: 'post',
				data: {'id':id, '_token': '{{csrf_token()}}' },
				dataType: 'json',
				success: function(data){
					//console.log(data);
					$('.searchable').html('');
					var html = '';
					var html2 = '';

					
					for(var i=0; i<data.concession_details.length; i++){
						if(data.concession_details[i].type == 'item'){
							html2 +=  data.concession_details[i].qty+' '+data.concession_details[i].items.name+'<br>';
						}else{
							html2 += '<b>'+data.concession_details[i].qty+' '+data.concession_details[i].packages.name+'</b><br>';
							var itemName = JSON.parse(data.concession_details[i].packages.itemName);
							var itemQty = JSON.parse(data.concession_details[i].packages.itemQty);
							for(var x=0; x<itemName.length; x++){
								html2 += '&nbsp;&nbsp;&nbsp;'+itemName[x]+' ('+itemQty[x]+')<br>';
							}
							
						}
					}

					var date = new Date(data.created_at).toDateString();

					html = `
						<tr>
							<td align="center" style="vertical-align:middle;">`+data.id+`</td>
							<td align="center" style="vertical-align:middle;">`+data.voucherNo+`</td>
							<td>`+html2+`</td>
							<td align="center" style="vertical-align:middle;">`+date+`</td>
							<td align="center" style="vertical-align:middle;">
								<a style="cursor:pointer;" onclick="reprint(`+data.id+`);" class="edit_btn" style="color:white;text-decoration:none;">Print</a>
							</td>
						</tr>
					`;

					$('.admin-table').show();
					$('.searchable').html(html);
				}
			});
		}
	});

	function reprint(id){
		$.post('printConcession' ,{'id':id, '_token':'{{csrf_token()}}'},  function(href){
			$('.admin-table').hide();
			$('.searchable').html('');
			window.open('reprintConcession/'+href);
		});
	}

</script>
@endsection
