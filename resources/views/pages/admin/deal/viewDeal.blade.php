@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li class="active">deals</li>
		</ol>
	</div><!--row-->

		<div class="row form-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<h3>Deals</h3>
					<div class="search-btn input-group" id="example_filter">
						<input id="filter" type="text" class="form-control search-control" placeholder="Search for...">
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
					<a class="pull-right add-button" href="{{ url('deal/create') }}">Add Deal</a>
				</div>
			</div><!--col-md-12-->
		</div><!--row-->

		@include('includes.error')
		@include('includes.success')

		<div class="row">
			<div class="col-md-12">	
				@if(count($deals)>0)
				<table border="1" cellpadding="0" cellspacing="0" id="example" class="  table table-hover tableView admin-table">
					<thead>
					<tr>
						<th>deal Name</th>
						<th>movie</th>
						<th>Deal</th>
						<th>Starting DateTime</th>
						<th>Ending DateTime</th>
						<th>status</th>
						<th></th>
						<th></th>

					</tr>
					</thead>
					<tbody class="searchable">
						@foreach($deals as $deal)
							<tr>
								<td>{{$deal->name}}</td>
								<td align="center"> 
									@if($deal->movie_id != null)
										{{$deal->movies->title}}
									@else
										<p>-</p>
									@endif
								</td>
								<td>
									@php 
										$type = json_decode($deal->type);
										$typeName = json_decode($deal->typeName);
										$qty = json_decode($deal->qty);
									@endphp
									@for($i=0; $i<count($type); $i++)
										@if($type[$i] == 'ticket')
											<span>Buy {{$deal->buyTicket}} To Get {{$qty[$i]}} Tickets Free</span><br>
										@elseif($type[$i] == 'item')
											<span>Buy {{$deal->buyTicket}} To Get {{$qty[$i]}} {{getItemById($typeName[$i])}} Free</span><br>
										@else
											<span>Buy {{$deal->buyTicket}} To Get {{$qty[$i]}} {{getPackageById($typeName[$i])}} Free</span><br>
										@endif
									@endfor
								</td>
								<td>{{date('d-M-Y h:i a',strtotime($deal->startDateTime))}}</td>
								<td>{{date('d-M-Y h:i a',strtotime($deal->endDateTime))}}</td>
								<td>
									@if($deal->status == 1)
										<p>active</p>
									@elseif($deal->status == 0)
										<p>Inactive</p>
									@else
										<p>planned</p>
									@endif
								</td>
								<td class="alignCenter"><a class="edit_btn" href="{{ url('deal/'.$deal->id.'/edit') }}">Edit</a></td>
							
								<td class="alignCenter">
									<form action="{{ url('deal/'.$deal->id) }}" method="post" id="delete{{$deal->id}}">
				                   		{{ csrf_field() }}
				                   		{{method_field("DELETE")}}
										<input type="hidden" class="id_to_delete" value="{{ $deal->id }}"><a style="cursor:pointer;" data-toggle="modal" data-target=".delete_confirm_modal"><img class="img_delete" src="{{ asset('assets/images/delete_icon.png') }}"/></a>
									</form>	
								</td>
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
		</div><!-- row -->
		<!-- Modal -->
		<div class="delete_confirm_modal modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		 	<div class="modal-dialog modal-sm">
			    <div class="modal-content">
			      Confirm Delete?
			    </div>
			    <div class="modal-footer">
			     	
			        <button type="button"  class="btn btn-default btn_yes" data-dismiss="modal" >Yes</button>
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			 
			    </div>
		  	</div>
		</div><!-- Modal -->

</div><!-- container -->
<br><br>
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