@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{ url('/') }}">Home</a></li>
		  <li><a href="{{ url('movie') }}">Movies</a></li>
		  <li class="active">Update Movie</li>
		</ol>
	</div><!--row-->
	{!! Form::model($movie , ['method' => 'PATCH','url' => ['movie', $movie->id], 'files'=>true, 'class' => 'form-horizontal dashboardForm']) !!}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> Film Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button" name="">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Save Changes</button>
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
								{!! Form::text('title' , null ,['id' => 'movie_title' ,'class' => 'form-control', 'required' => 'required']) !!}
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_distributer" class="col-sm-4 control-label"><span>*</span> Distributer Name: </label>
							<div class="col-sm-8">
								{!! Form::select('distributer_id', $distributers, null,['class' => 'form-control']) !!}
								{{-- <select name="distributer_id" class="form-control">
									@foreach($distributers as $distributer)
										<option value="{{$distributer->id}}" @if($distributer->id == $movie->distributers->id) {{'selected = "selected"'}} @endif>{{$distributer->name}}</option>
									@endforeach
								</select> --}}
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_rating" class="col-sm-4 control-label">Rating: </label>
							<div class="col-sm-8">
								{!! Form::text('rating' , null ,['id' => 'movie_rating' ,'class' => 'form-control']) !!}
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_year" class="col-sm-4 control-label">Release date: </label>
							<div class="col-sm-8">
								{!! Form::text('releaseDate' , null ,['id' => 'movie_release_date' ,'class' => 'form-control datetimepicker',  'autocomplete'=>'off' ]) !!}
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_genre" class="col-sm-4 control-label"><span>*</span> Genre: </label>
							<div class="col-sm-8">
								{!! Form::text('genre' , null ,['id' => 'movie_genre' ,'class' => 'form-control', 'required' => 'required']) !!}
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_duration" class="col-sm-4 control-label"><span>*</span> Duration minutes: </label>
							<div class="col-sm-8" >
								{!! Form::number('duration' , null ,['id' => 'movie_duration' ,'class' => 'form-control', 'required' => 'required']) !!}
							</div>
						</div>
					</div>

					<div class="clear"></div>
			
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_national_code" class="col-sm-4 control-label">National Code: </label>
							<div class="col-sm-8">
								{!! Form::text('nationalCode' , null ,['id' => 'movie_national_code' ,'class' => 'form-control']) !!}
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_format" class="col-sm-4 control-label">Movie Format: </label>
							<div class="col-sm-8">
								{!! Form::text('format' , null ,['id' => 'movie_format' ,'class' => 'form-control']) !!}
							</div>
						</div>
					</div>

					<div class="clear"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_synopsis" class="col-sm-4 control-label">Synopsis: </label>
							<div class="col-sm-8">
								{!! Form::textarea('synopsis' , null ,['id' => 'movie_synopsis' ,'class' => 'form-control', 'style' => 'height: 80px;', 'row' => '5']) !!}
							</div>
						</div>
					</div>
					
					<div class="clear"></div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="movie_trailor" class="col-sm-4 control-label">Trailor Embed Code: </label>
							<div class="col-sm-8">
								{!! Form::textarea('trailor' , null ,['id' => 'movie_trailor' ,'class' => 'form-control', 'style' => 'height: 80px;', 'row' => '5']) !!}
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
								{!! Form::select('status',[ '0' => 'Inactive' ,'1' => 'Active', '2' => 'Planned' ], null,['class' => 'form-control status']) !!}
								{{-- <select class="form-control status" name="status" required>
									<option value="1" @if($movie->status == 1) {{'selected = "selected"'}} @endif>Acive</option>
									<option value="2" @if($movie->status == 2) {{'selected = "selected"'}} @endif>Planned</option>
									<option value="0" @if($movie->status == 0) {{'selected = "selected"'}} @endif>Inactive</option>
								</select> --}}
							</div>
						</div>
					</div>

					<div class="clear"></div>

					<div class="col-md-12 movie-poster">
						@if($movie->poster != '')
							<div class="profilePic">
					           <span>
					            <img src="{{ asset('assets/images/uploads/m_'.$movie->poster) }}" class="img-responsive" alt="">
					            <a id="removeProfilePic"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
					           </span>
					        </div>

					        <div class="form-group" id="showNewPicSubmit" style="display:none;">
								<label for="movie_synopsis" class="col-sm-2 control-label">Image: </label>
								<div class="col-sm-10">
									{!! Form::File('poster' , ['class' => 'form-control', 'style' => 'width:100%;height:33px;']) !!}
								</div>
							</div>
						@else
					        <div class="form-group">
								<label for="movie_synopsis" class="col-sm-2 control-label">Image: </label>
								<div class="col-sm-10">
									{!! Form::File('poster' , ['class' => 'form-control', 'style' => 'width:100%;height:33px;']) !!}
								</div>
							</div>
						@endif
				        
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
									{!! Form::text('contractStartDate' , null ,['id' => 'movie_contract_start_date' ,'class' => 'form-control datetimepicker']) !!}
								</div>
							</div>
						</div>
					
						<div class="clear"></div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="movie_dist_seats" class="col-sm-4 control-label">Distributer Seats: </label>
								<div class="col-sm-8">
									{!! Form::text('distributerSeats' , null ,['id' => 'movie_dist_seats' ,'class' => 'form-control']) !!}
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
							@php $i = 0; @endphp
							@if(count(json_decode($movie->actor)) > 0)
							@foreach(json_decode($movie->actor) as $actor)
								<div class="row">
									<div class="col-md-12 row-el">
										<div class="col-md-5">
											<div class="form-group">
												<label class="col-sm-3 control-label">Actor</label>
												<div class="col-sm-9">
													<select name="actor[]" class="form-control">
														<option value="{{$actor}}">{{$actor}}</option>
													</select>
												</div>
										  	</div>
										</div><!-- col-md-4 -->	

										<div class="col-md-5">
											<div class="form-group">
												<label class="col-sm-3 control-label">Role</label>
													<div class="col-sm-9">
														{{-- {!! Form::select('role[]',json_decode($movie->role),[ 'Directors' => 'Directors' ,'Actor' => 'Actor', 'Producers' => 'Producers', 'Writer' => 'Writer' ], ['class' => 'form-control']) !!} --}}
														<select name="role[]" class="form-control">
															<option value="Directors" @if(json_decode($movie->role)[$i] == 'Directors') {{'selected = "selected"'}} @endif>Director</option>
															<option value="Actor" @if(json_decode($movie->role)[$i] == 'Actor') {{'selected = "selected"'}} @endif>Actor</option>
															<option value="Producers" @if(json_decode($movie->role)[$i] == 'Producers') {{'selected = "selected"'}} @endif>Producers</option>
															<option value="Writer" @if(json_decode($movie->role)[$i] == 'Writer') {{'selected = "selected"'}} @endif>Writer</option>
														</select>
													</div>
												</div>
										</div><!-- col-md-4 -->	

										<div class="col-md-2 txt-center">
											<button type="button" class="btn submitBtn minus-btn" value="" >Remove x</button>
										</div>
									</div><!-- row-el -->
								</div><!-- row -->
								@php $i++ @endphp
							@endforeach
							@endif
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
											{!! Form::select('role[]',[ 'Directors' => 'Directors' ,'Actor' => 'Actor', 'Producers' => 'Producers', 'Writer' => 'Writer' ], null,['class' => 'form-control']) !!}\
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