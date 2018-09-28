@foreach($movies as $movie)
	<div class="add-movie-item-rating">
		<div class="col-md-12 col-sm-12">
			<div class="movie-name-rating">
				<img class="round-shape" src="{{ asset('assets/images/round_shape.png') }}">Movie Name : <strong>{{$movie->title}}</strong><img class="rating-star" src="{{ asset('assets/images/rating_star.png') }}">
			</div><!-- movie-name-rating-->
		</div><!-- col-md-12-->
	</div><!-- add-movie-item-rating-->
	@if(count($movie->show_times)>0)
		@for($i=0; $i<count($movie->show_times); $i++)
			<div class="add-movie-item-data">
				<div class="col-md-12 col-sm-12">
					<div class="col-md-4 col-sm-4 movie-detail-data">
						<p>
							@if(date('Y-m-d', strtotime($movie->show_times[$i]->dateTime)) == date('Y-m-d'))
							<img class="round-shape" src="{{ asset('assets/images/round_shape.png') }}" style="background-color:red;border-radius:10px;">
							@endif
							{{date('Y-M-d D h:i a', strtotime($movie->show_times[$i]->dateTime))}}
						</p>
					</div><!-- col-md-9-->
					
					<div class="col-md-3 col-sm-3 movie-detail-data">
						<p>{{$movie->show_times[$i]->screens->name}}</p>
					</div>
					
					<div class="col-md-2 col-sm-2 movie-detail-data">
						<p>{{count($movie->show_times[$i]->bookings)}}</p>
					</div>
					
					<div class="col-md-3 col-sm-3 movie-detail-data">
						<p>{{ $movie->show_times[$i]->screens->totalSeats - count($movie->show_times[$i]->bookings)}}</p>
					</div>
				</div><!-- col-md-12-->
			</div><!-- add-movie-item-data-->
		@endfor
	@endif
@endforeach