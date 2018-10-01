@extends('layouts.t_master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('bookConcession')}}">Home</a></li>
		  <li class="active">Cancel Concession</li>
		</ol>
	</div><!--row-->

	<div class="row form-header">
		<div class="col-md-12">
			<div class="form-header-inner">
				<h3>Cancel Concession</h3>
				<div class="search-btn input-group">
					<input type="text" id="filter" class="form-control search-control" placeholder="Search for...">
						<span class="input-group-btn">
						<button class="btn btn-default search-btn" type="button"><img src="{{asset('assets/images/search-icon.png') }}"/></button>
					</span>
				</div><!-- /input-group -->
		 	</div>
	 	</div>
	</div><!--row-->
	
	<div class="row">
		<div class="col-md-12">	
			@if(count($conM) > 0)
			<table border="1" id="example" cellpadding="0" cellspacing="0" class="table table-hover tableView admin-table">
				<thead>
					<tr>
						<th>Order Id</th>
						<th>Sold by</th>
						<th>Order Amount</th>
						<th>Order time</th>
						<th>Reprint</th>
						<th>Cancel</th>
					</tr>
				</thead>
				<tbody class="searchable">
					@foreach($conM as $con)
						<tr class="forRemove{{$con->id}}">
							<td class="getId">{{$con->id}}</td>
							<td>{{$con->users->firstName}}</td>
							<td>{{$con->totalAmount }}</td>
							<td>{{date('d-M-y h:i', strtotime($con->created_at))}}</td>
							<td class="alignCenter"><a href="{{url('reprintConcession/'.$con->id)}}" target="_blank" class="edit_btn" style="color:white;text-decoration:none;">Reprint</a></td>
							<td class="alignCenter">
					            <textarea class="remarks"></textarea><br/><br/>
					            <input type="hidden" class="id_to_delete" value="{{$con->id}}">
					            <a style="cursor:pointer;" type="button" class="edit_btn img_delete" data-toggle="modal" data-target=".delete_confirm_modal" >Cancel</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			@else
				<p align="center"> no Record</p>
			@endif
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

	$(window).load(function(){
        $('.myModal').modal('show');
    });
	
	var id;
	var remarks;

	$(".container").on('click', '.img_delete',function() {
		id = $(this).parent().find('.id_to_delete').val();
		remarks  = $(this).parent().find('.remarks').val();
	});

	$(".modal-footer").on('click', '.btn_yes',function() {
		$.ajax({
			url: 'cancelCon',
			method: 'post',
			data: {'id':id, 'remarks':remarks, '_token': '{{csrf_token()}}' },
			dataType: 'json',
			success: function(data){
				$('.modal').modal('hide');
				$('.forRemove'+id).remove();
			}
		});
	});
</script>
@endsection
