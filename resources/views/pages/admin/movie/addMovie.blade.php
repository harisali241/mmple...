@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('movie') }}">Movies</a></li>
		  <li class="active">Add Movie</li>
		</ol>
	</div><!--row-->
	<form class="form-horizontal dashboardForm"  action="{{ route('movie.store') }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Film Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Add Film</button>
			 		</div>
			 	</div>
		 	</div>
		</div><!--row-->

		@include('includes.error')
	  	@include('includes.success')

		<div class="row">
			<div class="form-container">

				<div class="col-md-6">

					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_title" class="col-sm-4 control-label"><span>*</span> Movie Name: </label>
							<div class="col-sm-8">
								<input type="text" name="title" id="movie_title" class="form-control" required>
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_distributer" class="col-sm-4 control-label"><span>*</span> Distributer Name: </label>
							<div class="col-sm-8">
								<select class="form-control" name="distributer_id" required>
									<option value="" selected disabled>Select</option>
									@foreach($distributers as $dist)
										<option value="{{ $dist->id }}">{{ $dist->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_rating" class="col-sm-4 control-label">Rating: </label>
							<div class="col-sm-8">
								<input type="text" name="rating" id="movie_rating" class="form-control">
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_year" class="col-sm-4 control-label">Release date: </label>
							<div class="col-sm-8">
								<input type="text" name="releaseDate" id="movie_release_date" class="form-control datetimepicker" autocomplete="off">
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_genre" class="col-sm-4 control-label"><span>*</span> Genre: </label>
							<div class="col-sm-8">
								<input type="text" name="genre" id="movie_genre" class="form-control"  required>
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_duration" class="col-sm-4 control-label"><span>*</span> Duration minutes: </label>
							<div class="col-sm-8" >
								<input type="number" name="duration" id="movie_duration" class="form-control" required>
							</div>
						</div>
					</div>

					<div class="clear"></div>
			
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_national_code" class="col-sm-4 control-label">National Code: </label>
							<div class="col-sm-8">
								<input type="text" name="nationalCode" id="movie_national_code" class="form-control" >
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_format" class="col-sm-4 control-label">Movie Format: </label>
							<div class="col-sm-8">
								<input type="text" name="format" id="movie_format" class="form-control" >
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_synopsis" class="col-sm-4 control-label">Synopsis: </label>
							<div class="col-sm-8">
								<textarea name="synopsis" id="movie_synopsis" row="5" class="form-control" style="height: 80px;"></textarea>
							</div>
						</div>
					</div>
					
					<div class="clear"></div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_trailor" class="col-sm-4 control-label">Trailor Embed Code: </label>
							<div class="col-sm-8">
								<textarea name="trailor" id="movie_trailor" row="5" class="form-control" style="height: 80px;"></textarea>
							</div>
						</div>
					</div>
					
					<div class="clear"></div>
				</div><!-- col-md-6 -->

				<div class="col-md-4 col-md-offset-2">

					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_actors" class="col-sm-6 control-label"><span>*</span> Movie Status: </label>
							<div class="col-sm-6">
								<select class="form-control status" name="status" required>
									<option value="1">Acive</option>
									<option value="2">Planned</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>
					</div>

					<div class="clear"></div>

					<div class="col-md-12 movie-poster">
				        <div class="form-group">
							<label for="movie_synopsis" class="col-sm-2 control-label">Image: </label>
							<div class="col-sm-10">
								 <input type="hidden" class="form-control" name="poster" id="photo" readonly required>
								 <input type="file" name="poster" class="form-control" style="width:100%;height: 33px;" required>
							</div>
						</div>
					</div>	
				</div><!-- col-md-6 -->

			</div><!-- form-container -->
		</div><!-- row -->

		<div class="row">
			<div class="form-container bottom-container" style="padding-top:0px;">
					
					<div class="col-md-12 gray-header">
						<h3> Film Rental</h3>
					</div>

					<div class="col-md-6">
						
						<div class="col-md-12">
							<div class="form-group">
								<label for="movie_contract_start_date" class="col-sm-4 control-label">Contract Start Date: </label>
								<div class="col-sm-8">
									<input type="text" name="contractStartDate" id="movie_contract_start_date" class="form-control datetimepicker" >
								</div>
							</div>
						</div>
					
						<div class="clear"></div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="movie_dist_seats" class="col-sm-4 control-label">Distributer Seats: </label>
								<div class="col-sm-8">
									<input type="text" name="distributerSeats" id="movie_dist_seats" class="form-control" >
								</div>
							</div>
						</div>
					
						<div class="clear"></div>
					</div>	<!--col-m-6-->
					
					<div class="col-md-6">
					</div>	

					<div class="col-md-12 bottom-label">
						<div class="col-md-6">
							<h3>Actors, Directors & Producers.</h3>
							<span>Add or remove actors, directors and producers for this film below</span>
						</div>

						<div class="col-md-6 form-header-right">
							<button type="button" class="btn submitBtn person_btn save-button " value="" onclick="addRow1()">Add Person</button>
						</div>
					</div>

					<div class="col-md-12 ">
						<div id="content1">
							<div class="row">
								
							</div><!-- row -->
						</div><!-- #Content CLose -->
					</div><!-- col-md-12 -->	
			</div><!-- form-container -->
		</div><!--row -->

	</form>
</div>

@endsection

@section('scripts')
	
	<script>
        function addRow1() {
		var div = document.createElement('div');
		div.className = 'row';
		div.innerHTML = '<div class="col-md-12 row-el">\
								<div class="col-md-5">\
									<div class="form-group">\
										<label class="col-sm-3 control-label">Actor</label>\
										<div class="col-sm-9">\
											<select name="actor[]" class="form-control">@foreach($actors as $actor)<option value="{{$actor->name}}">{{$actor->name}}</option>@endforeach</select>\
										</div>\
								  	</div>\
								</div>\
								<div class="col-md-5">\
									<div class="form-group">\
										<label class="col-sm-3 control-label">Role</label>\
										<div class="col-sm-9">\
											<select name="role[]" class="form-control">\
												<option value="Directors">Director</option>\
												<option value="Actor">Actor</option>\
												<option value="Producers">Producers</option>\
												<option value="Writer">Writer</option>\
											</select>\
										</div>\
									</div>\
								</div>\
									<div class="col-md-2 txt-center">\
										<button type="button" class="btn submitBtn minus-btn" value="" >Remove x</button>\
									</div>\
								</div>\
							</div>';
		 document.getElementById('content1').appendChild(div);
		}
		
		
		// Minus Button function for Offer Page
			$("#content1").on('click', '.minus-btn', function() {
				$(this).parents('.row-el').parent('.row').remove();
			});
	</script>	

@endsection