@extends('layouts.master')
@section('content')


<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li class="active">Add Logo</li>
		</ol>
	</div><!--row-->
	
	<form class="form-horizontal dashboardForm"  action="{{ route('slideShow.store') }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Logo image</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Submit </button>
			 		</div>
			 	</div>
		 	</div>
	    </div><!--row-->

	    @include('includes.error')
		@include('includes.success')
				
		<div class="form-container">
			<div class="col-md-6">
				<div class="col-md-12 item_img">
				  <div class="form-group">
					<label for="movie_synopsis" class="col-sm-4 control-label">Add Image: </label>
					<div class="col-sm-8">
						<input type="file" name="image" class="form-control" style="width:100%;height: 33px;">
					</div>
				 </div>					       
				</div>
			</div><!-- col-md-6 -->
				
			<div class="col-md-6">
				<div class="col-md-12 item_img">
				
				</div>
			</div><!-- col-md-6 -->
				
		</div><!-- form-container -->

		@foreach($slideShows as $slideShow)
					
			<div class="form-container">
				<div class="col-md-3">
					<div class="col-md-12 item_img">
						@if(in_array('slideShow.destroy', getRoutes()))
					    	<input type="hidden" class="id_to_delete" value="{{$slideShow->id}}"><a data-toggle="modal" data-target=".delete_confirm_modal" onclick="deleteImg({{$slideShow->id}})"><span class="img_delete btn submitBtn cancel-button" name="delete_logo" style="width:100px;">Delete</span></a>
					    @endif
					</div>
				</div><!-- col-md-6 -->
				
				<div class="col-md-6">
					<div class="col-md-12 item_img">
					  <img src="{{ asset('assets/images/uploads/'.$slideShow->image) }}"/>			       
					</div>
				</div><!-- col-md-6 -->
				
			</div><!-- form-container -->
						
		@endforeach
	</form>
	  
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

	<form action="" method="post" id="deleteSlider">
		{{ csrf_field() }}
		{{method_field("DELETE")}}
	</form>	

@endsection

@section('scripts')
	
	<script type="text/javascript">

		var id = '';
		function deleteImg(sliderID){ id = sliderID; }

		$(document).ready(function(){
			$('.btn_yes').click(function(){
				$('#deleteSlider').attr('action', '{{url('slideShow/')}}/'+id );
				$('#deleteSlider').submit();
			});
		});

	</script>
	
@endsection