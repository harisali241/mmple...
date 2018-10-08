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

	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-3">
		  	<div class="search-btn input-group">
				<input type="text" name="searchFilter" class="form-control search-control wordToSearch" placeholder="Search by Ticket No...">
				<span class="input-group-btn">
					<button class="btn btn-default search-btn search-btn-ticket" type="button"><img  src="{{ asset('assets/images/search-icon.png') }}"/></button>
				</span>
			</div>
		</div>
		<div class="col-sm-3">
			<button type="button" style="border:none;" class="edit_btn filters">Filter</button>
		</div>
		<div class="col-sm-3">
			
		</div>
		<div class="col-sm-2">
			<button type="button" style="border:none;" class="edit_btn multiCancel" data-toggle="modal" data-target=".delete_confirm_modal">Multi Cancel</button>
		</div>
	</div>
	<div class="row form-container filter-box" style="display: none;">
		<div class="col-xs-12" style="margin-bottom:15px;">
			<h3 align="center">Filter</h3>
			<div class="col-sm-1"></div>

			<div class="col-sm-2">
				<select name="movie_id" class="movie_id form-control search-control columToSearch" style="">
					<option value="">Select Movie</option>
					@foreach($movies as $movie)
						<option value="{{$movie->id}}">{{$movie->title}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-sm-2">
				<select name="screen_id" class="screen_id form-control search-control columToSearch" style="">
					<option value="">Select Screen</option>
					@foreach($screens as $screen)
						<option value="{{$screen->id}}">{{$screen->name}}</option>
					@endforeach
				</select>
			</div> 
			<div class="col-sm-2">
				<select name="user_id" class="user_id form-control search-control columToSearch" style="">
					<option value="">Select User</option>
					@foreach($users as $user)
						<option value="{{$user->id}}">{{$user->firstName}}</option>
					@endforeach
				</select>
			</div> 
			<div class="col-sm-2">
				<input type="date" name="c_date" id="" class="c_date form-control" autocomplete="off">
			</div>
			<div class="col-sm-1">
				<button type="button" style="border:none;" class="edit_btn search-filter">Search</button>
			</div>
		</div>
	</div>
			
	<div class="row">
    	
        <div class="col-md-12 showNoRecord">
            <table border="1" id="example" cellpadding="0" cellspacing="0" class="table table-hover tableView admin-table" style="display:none;">
                <thead>
                    <tr>
                    	<th></th>
                        <th>Ticket Id</th>
                        <th>Movie</th>
                        <th>Ticket Genrated By</th>
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
				$('#hack').show();
			}else{
				var remarks = $('#delete'+id_to_delete).find('.remarks').val();
				deleteSingle(id_to_delete, remarks);
				$('#hack').show();
			}
		});

		function deleteSingle(id, remarks){
			
			$(document).ready(function(){
				$.ajax({
					url: baseUrl+'deleteTickets',
					method: 'post',
					type: 'json',
					data: {'id':id, 'remarks':remarks, '_token': '{{csrf_token()}}'},
					success: function(data){
						//console.log(data);
						if($.isArray(data)){
							for(var i=0; i<data.length; i++){
								$('.removeMe'+data[i]).remove();
							}
							$('.modal').modal('toggle');
						}else{	
							$('.removeMe'+data).remove();
							$('.modal').modal('toggle');
						}
						$('#hack').hide();					
					}
				});
			});
		}
		
		$(document).ready(function(){

			$('.search-btn-ticket').on('click', function(){
				$('.searchable').html('');
				if( $('.wordToSearch').val() != '' ){
					var columToSearch = 'id';
					var wordToSearch = $('.wordToSearch').val();
					$('.searchable').html('');
					$.ajax({
						url: baseUrl+'searchCancelTicket',
						method: 'post',
						type: 'json',
						data: {'columToSearch':columToSearch, 'wordToSearch':wordToSearch, 'sqlQuery':null, '_token': '{{csrf_token()}}'},
						success: function(data){
							//console.log(data);
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

			$('.filters').on('click', function (){
				if($('.filter-box').is(':hidden')){
					$(".filter-box").slideDown( 300, function() {
					    $('.filter-box').show();
					});
				}else{
					$(".filter-box").slideUp( 300, function() {
					    $('.filter-box').hide();
					});
					$('.movie_id').val('');
					$('.screen_id').val('');
					$('.user_id').val('');
					$('.c_date').val('');

				}
			});

			var movie_id = '';
			var screen_id = '';
			var user_id = '';
			var c_date = '';

			$('.movie_id').on('change', function (){
				if($(this).val() != ''){
					movie_id = `AND movie_id = "`+$(this).val()+`" `;
				}else{
					movie_id = '';
				}
			});
			$('.screen_id').on('change', function (){
				if($(this).val() != ''){
					screen_id = `AND screen_id = "`+$(this).val()+`" `;
				}else{
					screen_id = '';
				}
			});
			$('.user_id').on('change', function (){
				if($(this).val() != ''){
					user_id = `AND user_id = "`+$(this).val()+`" `;
				}else{
					user_id = '';
				}
			});

			$('.search-filter').on('click', function(){
				if($('.c_date').val() != ''){
					c_date = $('.c_date').val();
				}else{
					c_date = '';
				}

				var sqlQuery = ' status = "1" '+movie_id+screen_id+user_id;
				$.ajax({
					url: baseUrl+'searchCancelTicket',
					method: 'post',
					type: 'json',
					data: {'sqlQuery':sqlQuery, 'c_date':c_date, '_token': '{{csrf_token()}}'},
					success: function(data){
						$('.searchable').html('');
						if(data != ''){
							$('.tableView').show();
							$('.searchable').append(data);
						}else{
							$('.searchable').html('');
						}
					}
				});
			});

		});

	</script>

@endsection