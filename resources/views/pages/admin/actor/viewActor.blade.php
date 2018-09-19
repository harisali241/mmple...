@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li class="active">Persons</li>
		</ol>
	</div><!--row-->

	<div class="row form-header">
		<div class="col-md-12">
			<div class="form-header-inner">
				<h3>Persons</h3>
				<div class="search-btn input-group">
					<input type="text" id="filter" class="form-control search-control" placeholder="Search for...">
						<span class="input-group-btn">
						<button class="btn btn-default search-btn" type="button"><img  src="{{ asset('assets/images/search-icon.png') }}"/></button>
					</span>
				</div><!-- /input-group -->
		 	</div>
	 	</div>
	</div><!--row-->

	@include('includes.error')
	@include('includes.success')

	<div class="row">
		<div class="col-md-12">
			<div class="form-header-inner">
			<div class="alert alert-danger" role="alert" style="display:none;"> Assigned in movies! </div>
				@if(in_array('moviePerson.create', getRoutes()))<a class="pull-right add-button" href="{{ url('moviePerson/create') }}">Add Person</a>@endif
			</div>
		</div><!--col-md-12-->
	</div><!--row-->

	<div class="row">
		<div class="col-md-12">	

			@if(count($actors) > 0)
				<table border="1" cellpadding="0" cellspacing="0" id="example" class="table table-hover tableView admin-table">
					<thead>
						<tr>
							<th>Person Name</th>
							@if(in_array('moviePerson.edit', getRoutes()))<th></th>@endif
							@if(in_array('moviePerson.destroy', getRoutes()))<th></th>@endif
						</tr>
					</thead>
					<tbody class="searchable">
						@foreach($actors as $actor)
							<tr>
							<td>{{ $actor->name }}</td>
							@if(in_array('moviePerson.edit', getRoutes()))<td class="alignCenter"><a class="edit_btn" href="{{ url('moviePerson/'.$actor->id.'/edit') }}">Edit</a></td>@endif
							@if(in_array('moviePerson.destroy', getRoutes()))
							<td class="alignCenter">
								<form action="{{ url('moviePerson/'.$actor->id) }}" method="post" id="delete{{$actor->id}}">
			                   		{{ csrf_field() }}
			                   		{{method_field("DELETE")}}
									<input type="hidden" class="id_to_delete" value="{{ $actor->id }}"><a style="cursor:pointer;" data-toggle="modal" data-target=".delete_confirm_modal"><img class="img_delete" src="{{ asset('assets/images/delete_icon.png') }}"/></a>
								</form>	
							</td>
							@endif
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
</div><!-- Container Close -->

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

</div><!-- container -->

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