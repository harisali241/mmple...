@extends('layouts.master')
@section('content')


<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{url('/movieReport')}}">Reports Movie</a></li>
		  <li class="active">Shows By Time</li>
		</ol>
	</div><!--row-->
	<form class="form-horizontal dashboardForm" action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Shows By Time</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button">Cancel</button>
				 		<button type="button" class="btn submitBtn save-button">Generate Report</button>
			 		</div>
			 	</div>
		 	</div>
	    </div><!--row-->
	

	<div class="form-container">
		<div class="col-md-12">
			<div class="col-md-4">	
				<div class="form-group">
					<label for="" class="col-sm-4 control-label"><span>*</span> From Date: </label>
					<div class="col-sm-8">
						<input type="text" name="startDate" value="" class="form-control datetimepicker startDate" required autocomplete="off">
					</div>
				</div>
			</div>

			<div class="col-md-4">	
				<div class="form-group">
					<label for="" class="col-sm-4 control-label"><span>*</span> To: </label>
					<div class="col-sm-8">
						<input type="text" name="endDate" value="" class="form-control datetimepicker endDate" required autocomplete="off">
					</div>
				</div>
			</div>
			
			<div class="clear"></div>
		</div><!-- col-md-6 -->

			<div class="col-md-6"></div><!-- col-md-6 -->

		<div class="col-md-12">
		<div class="the-box full no-border">
			<div class="table-responsive">

				<table border="1" cellpadding="0" cellspacing="0"  class="table table-hover tableView admin-table" style="font-size: 12px; font-weight: bold;font-family: helvetica;">
					<thead>
						<th>No.</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Screen</th>
						<th>Movie</th>
					</thead>
					<tbody class="searchable">
						{{-- @if(isset($showTime))
							@foreach($showTime as $show)
							<tr>
								<td></td>
								<td>{{ $show->dateTime }}</td>
								<td>{{ $show->endDateTime }}</td>
								<td>{{ $show->screen_id }}</td>
								<td>{{ $show->movies->title }}</td>
							</tr>
							@endforeach
						@endif --}}
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div>	
		</div><!-- /col-md-12 -->
			
	</div>
	</form>
</div><!-- Container Close -->

@endsection

@section('scripts')
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('.admin-table').hide();
			$('.save-button').on('click', function(){
				var startDate = $('.startDate').val();
				var endDate = $('.endDate').val();
				$('#hack').show();
				$.ajax({
	                url: baseUrl+'/showsByTimeReports',
	                method:'POST',
	                dataType:'json',
	                data:{ 'startDate' : startDate , 'endDate' : endDate , '_token': '{{csrf_token()}}'},
	                success: function (data) {
						$('.admin-table').show();
						$('.searchable').html('');

						if(data.length > 0){
							var sNo = 1;
							for(var i=0; i< data.length; i++)
		                	{	
		                		$('.searchable').append(`
									<tr>
										<td>`+sNo+`</td>
										<td>`+data[i].dateTime+`</td>
										<td>`+data[i].endDateTime+`</td>
										<td>`+data[i].screens.name+`</td>
										<td>`+data[i].movies.title+`</td>
									</tr>
		                		`);
		                		sNo++;
		                	}
						}else{
							$('.searchable').append(`
								<tr>
									<td colspan="5" align="center">No Record</td>
								</tr>
		                	`);
						}
	                	$('#hack').hide();
	                },
	            });
			});
		});
	</script>	

@endsection