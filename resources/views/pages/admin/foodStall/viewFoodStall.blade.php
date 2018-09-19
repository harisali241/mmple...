@extends('layouts.master')
@section('content')
	

<div class="container">

	<div class="row">
			<ol class="breadcrumb">
			  <li><a href="{{ url('/') }}">Home</a></li>
			  <li class="active">Food Stalls</li>
			</ol>
	</div><!--row-->

	<div class="row form-header">
		<div class="col-md-12">
			<div class="form-header-inner">
				<h3>Food Stalls</h3>
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
		<div class="col-md-12">
			<div class="form-header-inner">
				<div class="alert alert-danger" role="alert" style="display:none;">Error! </div>
				@if(in_array('foodStall.create', getRoutes()))<a class="pull-right add-button" href="{{ url('foodStall/create') }}">Add Food Stall </a>@endif
			</div>
		</div><!--col-md-12-->
	</div><!--row-->

	@include('includes.error')
  	@include('includes.success')

	<div class="row">
		
		<div class="col-md-12">	
			@if( count($foodStalls) > 0 )
				<table border="1" id="example" cellpadding="0" cellspacing="0" class="table table-hover tableView admin-table">
					<thead>
					<tr>
						<th>Item Name</th>
						<th>Item Size</th>
						<th>Item Date</th>
						<th>Status</th>
						@if(in_array('foodStall.edit', getRoutes()))<th></th>@endif
						@if(in_array('foodStall.destroy', getRoutes()))<th></th>@endif
					</tr>
					</thead>
					<tbody class="searchable">
						@foreach($foodStalls as $foodStall)
							<tr>
								<td>{{ $foodStall->name }}</td>
								<td>{{ $foodStall->size }}</td>
								<td>{{ $foodStall->date }}</td>
								<td>
									@if($foodStall->status == 1)
										<p>active</p>
									@elseif($foodStall->status == 0)
										<p>Inactive</p>
									@else
										<p>planned</p>
									@endif
								</td>


								@if(in_array('foodStall.edit', getRoutes()))<td class="alignCenter"><a class="edit_btn" href="{{ url('foodStall/'.$foodStall->id.'/edit') }}">Edit</a></td>@endif
								@if(in_array('foodStall.destroy', getRoutes()))
								<td class="alignCenter">
									<form action="{{ url('foodStall/'.$foodStall->id) }}" method="post" id="delete{{$foodStall->id}}">
				                   		{{ csrf_field() }}
				                   		{{method_field("DELETE")}}
										<input type="hidden" class="id_to_delete" value="{{ $foodStall->id }}"><a style="cursor:pointer;" data-toggle="modal" data-target=".delete_confirm_modal"><img class="img_delete" src="{{ asset('assets/images/delete_icon.png') }}"/></a>
									</form>	
								</td>
								@endif
							</tr>
						@endforeach
						</tbody>
				</table>
			@else
				<p align="center">
					No Record
				</p>
			@endif
		</div>
	</div><!-- Row Close -->

	<div class="delete_confirm_modal modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      Confirm Delete?
	    </div>
	    <div class="modal-footer">
	        <button type="button" class="btn btn-default btn_yes" data-dismiss="modal">Yes</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	    </div>
	  </div>
	</div><!-- Modal -->

</div><!-- Container Close -->

@endsection
@section('scripts')
	
	<script type="text/javascript">
		var id_to_delete;

		$(".container").on('click', '.img_delete',function() {
			id_to_delete = $(this).parent().parent().find('.id_to_delete').val();
		});

			$(".modal-footer").on('click', '.btn_yes',function() {
				console.log(id_to_delete);
				$("#delete"+id_to_delete).submit();
			});
	</script>
	
@endsection