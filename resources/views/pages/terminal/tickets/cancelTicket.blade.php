@extends('layouts.t_master')
@section('content')

	
<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li class="active">Cancel Tickets</li>
		</ol>
	</div><!--row-->

	<div class="row form-header">
		<div class="col-md-12">
			<div class="form-header-inner">
				<h3>Cancel Tickets</h3>
				<div class="search-btn input-group">
					<input type="text" id="filter" class="form-control search-control" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default search-btn" type="button"><img  src="{{ asset('assets/images/search-icon.png') }}"/></button>
					</span>
				</div><!-- /input-group -->
		 	</div>
	 	</div>
	</div><!--row-->

  	<div class="col-sm-2" style="margin-left: 47px;">
	  	<div class="search-btn input-group">
			<select name="selection" class="form-control search-control columToSearch" style="">
				<option value="count_asc">Search by Counts - Asc</option>
				<option value="count_desc">Search by Counts - Desc</option>
				<option value="id">Search by Ticket No</option>
			</select>
		</div>
	</div>
	<div class="col-sm-3">
	  	<div class="search-btn input-group">
			<input type="text" name="searchFilter" class="form-control search-control wordToSearch" placeholder="Search by count OR Ticket No...">
			<span class="input-group-btn">
				<button class="btn btn-default search-btn search-btn-ticket" type="button"><img  src="{{ asset('assets/images/search-icon.png') }}"/></button>
			</span>
		</div>
	</div>

			
{{--     <style>
        .userLoginPanel { display:none; }
    </style> --}}
				
        <div class="row">
        	<div style="float:right;margin-right:80px;margin-top:10px;margin-bottom:10px;">
	            <a style="cursor:pointer;" type="button" class="edit_btn multiCancel" data-toggle="modal" data-target=".delete_confirm_modal">Multi Cancel</a>
	        </div>
            <div class="col-md-12 showNoRecord">
                <table border="1" id="example" cellpadding="0" cellspacing="0" class="table table-hover tableView admin-table" style="display:none;">
                    <thead>
	                    <tr>
	                    	<th></th>
	                        <th>Ticket Id</th>
	                        <th>Movie</th>
	                        <th>Screen name</th>
	                        <th>Show Date & time</th>
	                        <th>Seat id</th>
	                        <th>Printed date</th>
	                        <th>Remarks & Cancel</th>
	                    </tr>
                    </thead>
                    <tbody class="searchable">
                    	
                    </tbody>
                </table>
               
			</div><!-- Container Close -->
		</div>

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
</div>
<br><br>
@endsection
@section('scripts')

	<script type="text/javascript">
			var checkId = [];
			var multiRemarks = [];
			$(document).ready(function(){
				$('.multiCancel').on('click', function(){
					checkId = [];
					multiRemarks = [];
					$(".container .allCancel").each(function () {
						if($(this).is(':checked')){
							checkId.push($(this).val());
						}
					});
					$(".container .remarks").each(function () {
						if($(this).parent().parent().parent().find('.idFromhere').find('.allCancel').is(':checked') ){
							multiRemarks.push($(this).val());
						}
					});
				});
			});

			var id_to_delete;

			$(".container").on('click', '.img_delete',function() {
				id_to_delete = $(this).parent().find('.id_to_delete').val();
			});

			$(".modal-footer").on('click', '.btn_yes',function() {
				console.log();
				if(checkId[0] != undefined){
					deleteSingle(checkId, multiRemarks);
					checkId = [];
					multiRemarks = [];

				}else{
					var remarks = $('#delete'+id_to_delete).find('.remarks').val();
					deleteSingle(id_to_delete, remarks);
				}
			});
		function deleteSingle(id, remarks){
			$(document).ready(function(){
				$.ajax({
					url: 'deleteTickets',
					method: 'post',
					type: 'json',
					data: {'id':id, 'remarks':remarks, '_token': '{{csrf_token()}}'},
					success: function(data){
						if($.isArray(data)){
							for(var i=0; i<data.length; i++){
								$('.removeMe'+data[i]).remove();
							}
							$('.modal').modal('toggle');
						}else{	
							$('.removeMe'+data).remove();
							$('.modal').modal('toggle');
						}					
					}
				});
			});
		}
		
		$(document).ready(function(){

			$('.search-btn-ticket').on('click', function(){
				$('.searchable').html('');
				if( $('.wordToSearch').val() != '' ){
					var columToSearch = $('.columToSearch').val();
					var wordToSearch = $('.wordToSearch').val();
					$('.searchable').html('');
					$.ajax({
						url: 'searchCancelTicket',
						method: 'post',
						type: 'json',
						data: {'columToSearch':columToSearch, 'wordToSearch':wordToSearch, '_token': '{{csrf_token()}}'},
						success: function(data){
							if(data != ''){
								$('.tableView').show();
								$('.searchable').append(data);
							}else{
								$('.searchable').html('');
							}
						}
					});
				}else{
					$('.tableView').hide();
					$('.searchable').html('');
				}
			});

			$('.multiCancel').on('click', function(){
				var checkId = [];
				var multiRemarks = []
				$(".container .allCancel").each(function () {
					if($(this).is(':checked')){
						checkId.push($(this).val());
					}
				});
				$(".container .remarks").each(function () {
					if($(this).parent().parent().parent().find('.idFromhere').find('.allCancel').is(':checked') ){
						multiRemarks.push($(this).val());
					}
				});
				
				//deleteSingle(checkId, multiRemarks);
			});

		});
	</script>

@endsection