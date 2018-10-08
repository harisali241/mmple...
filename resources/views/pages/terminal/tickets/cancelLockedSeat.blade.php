@extends('layouts.t_master')
@section('content')

	
<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/booking')}}">Home</a></li>
		  <li class="active">Cancel Lock seats</li>
		</ol>
	</div><!--row-->

	<div class="row form-header">
		<div class="col-md-12">
			<div class="form-header-inner">
				<h3>Cancel Lock seats</h3>
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
				<option value="seatNumber">Search by Seat No</option>
			</select>
		</div>
	</div>
	<div class="col-sm-3">
	  	<div class="search-btn input-group">
			<input type="text" name="searchFilter" class="form-control search-control wordToSearch" placeholder="Search by count OR Seat No...">
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
	                    	<th>Seat Name</th>
                            <th>Screan</th>
                            <th>Show Time</th>
                            <th>Locked time</th>
                            <th></th>
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
			$(document).ready(function(){
				$('.multiCancel').on('click', function(){
					checkId = [];
					$(".container .allCancel").each(function () {
						if($(this).is(':checked')){
							checkId.push($(this).val());
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
					deleteSingle(checkId);
					checkId = [];
				}else{
					deleteSingle(id_to_delete);
				}
			});

		function deleteSingle(id){
			$(document).ready(function(){
				$.ajax({
					url: baseUrl+'deleteLockedSeat',
					method: 'post',
					type: 'json',
					data: {'id':id, '_token': '{{csrf_token()}}'},
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
						url: baseUrl+'searchCancelSeat',
						method: 'post',
						type: 'json',
						data: {'columToSearch':columToSearch, 'wordToSearch':wordToSearch, '_token': '{{csrf_token()}}'},
						success: function(data){
							console.log(data);
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
			});

		});
	</script>

@endsection