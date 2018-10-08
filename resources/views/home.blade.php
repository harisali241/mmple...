@extends('layouts.master')

@section('content')


   <div class="container main-container">
		<div class="row">
			<div class="col-md-7 content-left">
				<div class="row">
					<div class="col-md-12 col-sm-12 program-movie">
						<div class="col-md-7 col-sm-7">
							Programs & Movies <span>(Cinemas & Timings)</span>
						</div><!-- col-md-6 -->
						<div class="col-md-6 col-sm-6 add-a-movie navbar-right dropdown settings">
							
						</div>
					</div><!-- program-movie -->
				</div><!-- row -->
				
				<div class="row">
					<div class="col-md-8 col-md-offset-4 form-horizontal" style="position:relative;">
						<div class="alert alert-danger" id="invalid_time" style="display:none;position:absolute;" role="alert">Invalid Time!</div>
						<label for="itemname" class="col-sm-4 control-label" style=" padding-top: 15px;">Go Date: </label>
						<div class="col-sm-6">
							<div class="input-group date" style="margin-top: 10px; margin-bottom: 10px;">
						        <input type="date" id="animateDate" class="form-control">
						        <span class="input-group-addon" id="go" onclick="go()">
						            <span class="glyphicon glyphicon-calendar"></span>
						        </span>
						    </div>
						</div>
					</div>
				</div><!-- row -->
				
				<div class="row">
					<div class="col-md-12 col-sm-12 timeline nopadding">
						<div id="mytimeline"></div>
					</div>
				</div><!-- row -->
				
				<div class="clear"></div>
				
				<div class="row">
					<div class="col-md-12 col-sm-12 nopadding" id="maxscroll">
						
						<!-- top-sell -->
						<div class="col-md-6  col-sm-12 nopadding ">
							<div class="top-sellers">
								<div class="col-md-12 col-sm-12 top-sellers-head">
									<p>Top 10 Sellers <span>(Our Mesmorizing Services)</span></p>
									<img src="{{ asset('assets/images/setting.png') }}"/>
								</div><!-- top-sellers-head -->
								
								<div class="col-md-12 col-sm-12 top-sell-row nopadding">
									<div class="col-md-4 col-sm-4 top-sell-label">Item Name</div>
									<div class="col-md-4 col-sm-4 top-sell-label">Qty</div>
									<div class="col-md-4 col-sm-4 top-sell-label">Amount</div>
								</div>
								<!-- top-sellers-label -->
								<div class="dashbordTopSellers">
									@php $count = 0; @endphp
									@foreach($topSellers as $top)
										<div class="col-md-12 col-sm-12 top-sell-row  nopadding">
											<div class="col-md-4 col-sm-4 top-sell-data">{{ $top['name'] }}</div>
											<div class="col-md-4 col-sm-4 top-sell-data">{{ $top['qty'] }}</div>
											<div class="col-md-4 col-sm-4 top-sell-data">{{ $top['price'] }}</div>
										</div>
										@php $count++; @endphp
										@if($count == 10) @php break; @endphp @endif
									@endforeach
								</div>
							</div><!-- top-sellers-->
					    </div><!-- col-md-6-->
						<!-- /top-sell-->
						
						<!-- daily-stat-->
						<div class="col-md-6 col-sm-12 nopaddingright daily-states">
							<div class="top-sellers">
								<div class="col-md-12 col-sm-12 top-sellers-head">
									<p>Daily Statistics <span>(Ticket Sales)</span></p>
									<img src="{{ asset('assets/images/setting.png') }}"/>
								</div><!-- top-sellers-head-->
								
								<div class="clear"></div>

								<div class="col-md-12 col-sm-12 daily-states-row  nopadding">
									<div class="col-md-3 col-xs-3 top-sell-label">Today</div>
									<div class="col-md-5 col-xs-5 top-sell-label">Name</div>
									<div class="col-md-4 col-xs-4 top-sell-label">Total</div>
								</div>
								<div class="dashbordticketSales">
									@foreach($ticketSales as $ticket)
										<!-- daily-states-dat-->
										@if(todayTicket($ticket)>0)
										<div class="col-md-12 col-sm-12 daily-states-row  nopadding">
											<div class="col-md-3 col-xs-3 daily-states-data">{{todayTicket($ticket)}}</div>
											<div class="col-md-5 col-xs-5 daily-states-data"><span>{{$ticket->firstName}}</span></div>
											<div class="col-md-4 col-xs-4 daily-states-data"><span>{{count($ticket->bookings)}}</span></div>
										</div>
										@endif
										<!-- daily-states-data-->
									@endforeach
								</div>
								<!-- POS Operators-->
								<!-- POS Operators-head-->
								<div class="col-md-12 col-sm-12 top-sellers-head">
									<p>Daily Statistics <span>(Concession Sale)</span></p>
									<img src="{{ asset('assets/images/setting.png') }}"/>
								</div><!-- POS Operators-head-->
								
								<div class="clear"></div>

								<div class="col-md-12 col-sm-12 daily-states-row  nopadding">
									<div class="col-md-3 col-xs-3 top-sell-label">Today</div>
									<div class="col-md-5 col-xs-5 top-sell-label">Name</div>
									<div class="col-md-4 col-xs-4 top-sell-label">Total</div>
								</div>
								
								<div class="dashbordConSales">
									@foreach($concessionSales as $con)
										<!-- daily-states-dat-->
										@if(todayConsession($con)>0)
										<div class="col-md-12 col-sm-12 daily-states-row  nopadding">
											<div class="col-md-3 col-xs-3 daily-states-data">{{todayConsession($con)}}</div>
											<div class="col-md-5 col-xs-5 daily-states-data"><span>{{$con->firstName}}</span></div>
											<div class="col-md-4 col-xs-4 daily-states-data"><span>{{count($con->concession_details)}}</span></div>
										</div>
										@endif
										<!-- daily-states-data-->
									@endforeach
								</div>
								
							</div><!-- top-sellers-->
						</div><!-- col-md-6 -->
						
					
					</div>
				</div><!-- row -->

			</div><!-- col-md-7-->
			
			<div class="col-md-5 padding5">
				<div class="cinema-program-bg" id="cinema-program-bg">
					<div class="col-md-12 col-sm-12 add-deals-head">
					 <div class="col-md-6 col-sm-6  nopadding">	
						<p>Programs & Movies (Cinemas & Timings)</p>
						</div><!-- col-md-6-->
						<div class="col-md-6 col-sm-6  nopadding">	
						<div class="navbar-right dropdown settings ">
						  <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img  src="{{ asset('assets/images/setting.png') }}"/></a>
						  <ul class="dropdown-menu">
							<li><a href="#">HTML</a></li>
							<li><a href="#">CSS</a></li>
							<li><a href="#">JavaScript</a></li>
						  </ul>
						</div>
					</div><!-- col-md-6-->
						
					</div><!-- add-deals-head-->
					
					<div class="movie-detail-labels">
						<div class="col-md-4 col-sm-4 detail-label">
							<p>Time</p>
						</div><!-- col-md-9-->
						
						<div class="col-md-3 col-sm-3 detail-label">
							<p>Screen</p>
						</div>
						
						<div class="col-md-2 col-sm-2 detail-label">
							<p>Sold</p>
						</div>
						
						<div class="col-md-3 col-sm-3 detail-label">
							<p>Available</p>
						</div>
					</div><!-- movie-detail-labels-->

					<div class="dashbordMovies">
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
					</div>

				</div><!-- deal-bg-->
				
			</div><!-- col-md-5-->
			
			
		</div><!-- row -->
			
		<div>
   </div><!-- container -->

@endsection
@section('scripts')
	
	<script type="text/javascript">
		showGraph();
		$(document).ready(function(){
			setInterval(function() {
				showGraph();
			}, 303000);		
		});

		function showGraph(){
			var data = [
			    @php
			    foreach($showTimes as $showtime) {
			        $initial_time = $showtime->dateTime;
			        $initial_time1 = strtotime($initial_time);
			        $initial_time2 = date('Y,m,d,H,i,s', $initial_time1);
			        list($year, $month, $day, $hour, $minute, $second) = explode(",", $initial_time2);
			        if($month == '01'){
			            $month = '00';
			            $initial_time3 = $year.",".$month.",".$day.",".$hour.",".$minute.",".$second;
			        }else{
			            $month = +$month - 1;
			            $initial_time3 = $year.",".$month.",".$day.",".$hour.",".$minute.",".$second;
			        }
			        //echo $month;
			        //$initial_time1 = strtotime($initial_time . ' -1 month');
			        //$initial_time2 = date('Y,m,d,H,i,s', $initial_time1);
			        $movie_time = $showtime->movies->duration;
			        $cleanup_time = $showtime->timings->cleanUpDuration;
			        $trailer_time = $showtime->timings->trailerDuration - 5;
			        $interval_time = $showtime->timings->intervalDuration;

			        $total_time = $cleanup_time + $trailer_time + $movie_time + $interval_time;
			       
			        $final_time = date('Y-m-d H:i:s', $initial_time1);
			        $final_time2 = strtotime($final_time . ' + '.$total_time.' minutes');
			        $final_time3 = date('Y,m,d,H,i,s', $final_time2);
			        list($yearf, $monthf, $dayf, $hourf, $minutef, $secondf) = explode(",", $final_time3);
			        if($monthf == '01'){
			            $monthf = '00';
			            $final_time4 = $yearf.",".$monthf.",".$dayf.",".$hourf.",".$minutef.",".$secondf;
			        }else{
			            $monthf = +$monthf - 1;
			            $final_time4 = $yearf.",".$monthf.",".$dayf.",".$hourf.",".$minutef.",".$secondf;
			        }

			        $start_label = date('H:i:s', $initial_time1);
			        $end_label = date('H:i:s', $final_time2);
			    	@endphp
			        {
			            'start': new Date({{ $initial_time3 }}), 
			            'end': new Date({{ $final_time4 }}),
			            'content': '<a href="{{url('showTime/'.$showtime->id.'/edit')}}">{{ $showtime->movies->title }} ( {{ $showtime->movies->duration }} min)<p class="film_small_desc"> Start Time: {{ $start_label }} End Time: {{ $end_label }}</p></a>',
			            'editable': false,
			            'group': '{{ $showtime->screens->name }}',
			            'className': 'timeline_film_detail {{ $showtime->color }}'
			        },
			    	@php 
				} 	@endphp
			];
		    // specify options
		    var options = {
		        'width':  '100%',
		        'height': '260px',
		        'editable': true,   // enable dragging and editing events
		        'layout': 'box',
				axisOnTop: true,
		        start: new Date(2015,9,23,0,0,0),
				/*min: new Date(2010,7,20,0,0,0),
				max: new Date(2010,8,20,24,0,0),*/
				'zoomable':false,
				"intervalMin": 3600000 * 7, // one hour in milliseconds
				"intervalMax": 3600000 * 7 , 			
		    };
		    // Instantiate our timeline object.
		    var timeline = new links.Timeline(document.getElementById('mytimeline'), options);
		    // cancel any running animation as soon as the user changes the range
	        links.events.addListener(timeline, 'rangechange', function (properties) {
	            animateCancel();
	        });
		    // Draw our timeline with the created data and options
		    timeline.draw(data);
			// create a simple animation
	        var animateTimeout = undefined;
	        var animateFinal = undefined;
	        function animateTo(date) {
	            // get the new final date
	            var d = new Date(date);
	            var n = d.getMonth();
	            if(n == 1){var date1 = d.setMonth(0);}
	            else{var date1 = d.setMonth(+n-1);}
	            animateFinal = date1.valueOf();
	            timeline.setCustomTime(date1);
	            // cancel any running animation
	            animateCancel();
	            // animate towards the final date
	            var animate = function () {
	                var range = timeline.getVisibleChartRange();
	                var current = (range.start.getTime() + range.end.getTime())/ 2;
	                var width = (range.end.getTime() - range.start.getTime());
	                var minDiff = Math.max(width / 1000, 1);
	                var diff = (animateFinal - current);
	                if (Math.abs(diff) > minDiff) {
	                    // move towards the final date
	                    var start = new Date(range.start.getTime() + diff / 4);
	                    var end = new Date(range.end.getTime() + diff / 4);
	                    timeline.setVisibleChartRange(start, end);
	                    // start next timer
	                    animateTimeout = setTimeout(animate, 50);
	                }
	            };
	            animate();
	        }
	        function animateCancel () {
	            if (animateTimeout) {
	                clearTimeout(animateTimeout);
	                animateTimeout = undefined;
	            }
	        }

	        function go () {
	            // interpret the value as a date formatted as "yyyy-MM-dd"
	            var v = document.getElementById('animateDate').value.split('-');
	            var date = new Date(v[0], v[1], v[2]);
	            if (date.toString() == "Invalid Date") {
	                $('#invalid_time').fadeIn('slow').delay(1000).fadeOut('slow');
	            }
	            else {
	                animateTo(date);
	            }
	        }

			$(document).ready(function(){
			   	@php
			    	$getnowdate= date('Y-m-d') ;
			    @endphp
			        //For Edit
			    $('#animateDate').val('{{$getnowdate}}');
			    go();
			});
		}
	</script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			setInterval(function() {
				$.ajax({
					url: baseUrl+'dashbordMovies',
					method: 'post',
					type: 'json',
					data: {'_token': '{{csrf_token()}}'},
					success: function(data){
						$('.dashbordMovies').html(data);
					}
				});

				$.ajax({
					url: baseUrl+'dashbordTopSellers',
					method: 'post',
					type: 'json',
					data: {'_token': '{{csrf_token()}}'},
					success: function(data){
						$('.dashbordTopSellers').html(data);
					}
				});

				$.ajax({
					url: baseUrl+'dashbordticketSales',
					method: 'post',
					type: 'json',
					data: {'_token': '{{csrf_token()}}'},
					success: function(data){
						$('.dashbordticketSales').html(data);
					}
				});

				$.ajax({
					url: baseUrl+'dashbordConSales',
					method: 'post',
					type: 'json',
					data: {'_token': '{{csrf_token()}}'},
					success: function(data){
						$('.dashbordConSales').html(data);
					}
				});
			}, 5000);		
		});
	</script>
@endsection