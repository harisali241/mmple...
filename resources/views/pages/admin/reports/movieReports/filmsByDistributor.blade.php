@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('/movieReport') }}">Reports Movie</a></li>
		  <li class="active">Films by Distributer</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm"  action="" method="post">
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Films by distributers</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			{{-- <button type="button" class="btn submitBtn cancel-button">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button" >Generate Report</button>		 --}}
			 		</div>
			 	</div>
		 	</div>
	    </div><!--row-->

	
		<div class="form-container">
				
			<div class="col-md-6">
			
				<div class="col-md-12">	
					<div class="form-group">
						<label for="ticket_class" class="col-sm-4 control-label"><span>*</span> Select Distributer: </label>
						<div class="col-sm-8">
							<select class="form-control distributer" name="distributer_id" required>
								<option value="" selected disabled>Select</option>
								@foreach($distributers as $dist)
									<option value="{{$dist->id}}">{{$dist->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>			
				<div class="clear"></div>
			</div><!-- col-md-6 -->

			<div class="col-md-6"></div><!-- col-md-6 -->
		</div>
	</form>
	
	<div class="col-md-12">
		<div class="the-box full no-border">
			<div class="table-responsive">
				
				<table border="1" cellpadding="0" cellspacing="0" class="table table-hover tableView admin-table">
					<thead>
						<th>No.</th>
						<th>Movie Name</th>
						<th>Contract type</th>
						<th>Contract Start Date</th>
					</thead>
					<tbody class="reportData">
						

					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div>	
	</div><!-- /col-md-12 -->

</div><!-- Container Close -->

@endsection

@section('scripts')
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('.admin-table').hide();
			$('.distributer').on('change', function(){
				var id = $(this).val();
				//console.log(id);
				$('#hack').show();
				$.ajax({
	                url: '/filmsByDistributorReports',
	                method:'POST',
	                dataType:'json',
	                data:{ 'id' : id , '_token': '{{csrf_token()}}'},
	                success: function (data) {
						$('.admin-table').show();
						$('.reportData').html('');
						if(data.length > 0){
							var sNo = 1;
							var contractType = '';
							var contractStartDate = '';
							for(var i=0; i< data.length;i++)
		                	{	
								if(data[i].contractType!=null){
		                			contractType = data[i].contractType
		                		}
		                		if(data[i].contractStartDate!=null){
		                			contractStartDate = data[i].contractStartDate
		                		}
		                		$('.reportData').append(`
									<tr>
										<td>`+sNo+`</td>
										<td>`+data[i].title+`</td>
										<td>`+contractType+`</td>
										<td>`+contractStartDate+`</td>
									</tr>
		                		`);
		                		sNo++;
		                	}
						}else{
							$('.reportData').append(`
								<tr>
									<td colspan="4" align="center">No Record</td>
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