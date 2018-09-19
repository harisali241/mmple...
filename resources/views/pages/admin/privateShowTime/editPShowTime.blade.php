@extends('layouts.master')
@section('content')

<div class="container">

	<div class="row">
		<div class="col-md-8">
			<ol class="breadcrumb">
			  <li><a href="{{ url('/') }}">Home</a></li>
			  <li><a href="{{ url('/privateShowTime') }}">Show times</a></li>
			  <li class="active">Update Show times</li>
			</ol>
		</div>

		<div class="col-md-4 form-horizontal" style="position:relative;">
		<div class="alert alert-danger" id="invalid_time" style="display:none;position:absolute;" role="alert">Invalid Time!</div>
			<label for="itemname" class="col-sm-3 control-label" style=" padding-top: 15px;">Go Date: </label>
			<div class="col-sm-7">
				<div class="input-group date" style="margin-top: 10px; margin-bottom: 10px;">
			        <input type="date" id="animateDate" class="form-control">
			        <span class="input-group-addon" id="go" onclick="go()">
			            <span class="glyphicon glyphicon-calendar"></span>
			        </span>
			    </div>
			</div>
		</div>
	</div><!--row-->

	<div class="row">
		<div class="col-md-12 col-sm-12 timeline">
			<div id="mytimeline">
				
			</div>
		</div>
	</div><!-- row -->

	{!! Form::model($showTime, ['method' => 'PATCH','url' => ['showTime', $showTime->id], 'files'=>true, 'class' => 'form-horizontal dashboardForm']) !!}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3>Showtime Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Save Changes</button>
				 		
			 		</div>
			 	</div>
		 	</div>
		</div><!--row-->

		@include('includes.error')
		@include('includes.success')
		
	<div class="form-container">
				
		<div class="col-md-6">
			<div class="col-md-12">	
				<div class="form-group">
					<label for="showtime_movie_id" class="col-sm-4 control-label"><span>* </span> Show Movie: </label>
					<div class="col-sm-8">
						{!! Form::select('movie_id', $movies, null,['id'=>'showtime_movie_id' ,'class' => 'form-control', 'required' => 'required']) !!}
					</div>
				</div>
			</div>

			<div class="clear"></div>
			<div class="col-md-12">	
				<div class="form-group">
					<label for="showtime_screen_id" class="col-sm-4 control-label"><span>* </span> Show Screen: </label>
					<div class="col-sm-8">
						{!! Form::select('screen_id', $screens, null,['id'=>'showtime_screen_id' ,'class' => 'form-control', 'required' => 'required']) !!}
					</div>
				</div>
			</div>
			
				<div class="clear"></div>


				<div class="col-md-12">	
					<div class="form-group">
						<label for="showtime_voucher_type" class="col-sm-4 control-label"><span>* </span> Voucher type: </label>
						<div class="col-sm-8">
							{!! Form::select('voucher_id', $vouchers, null,['class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>

				<div class="clear"></div>

			</div><!-- col-md-6 -->

			<div class="col-md-6">

			<div class="col-md-11 col-md-offset-1">	
					<div class="form-group">
						<label for="showtime_status" class="col-sm-4 control-label"><span>* </span>Status: </label>
						<div class="col-sm-4">
							{!! Form::select('status',[ '0' => 'Inactive' ,'1' => 'Active', '2' => 'Planned' ], null,['class' => 'form-control status']) !!}
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

				

				<div class="col-md-11 col-md-offset-1">	
					<div class="form-group">
						<label for="showtime_complimentry_seats" class="col-sm-4 control-label"><span>* </span>Allow complimentry: </label>
						<div class="col-sm-8">
							{!! Form::select('complimentrySeat',[ '1' => 'Yes' ,'0' => 'No' ], null,['class' => 'form-control']) !!}
						</div>
					</div>
				</div>

				<div class="clear"></div>

				<div class="col-md-11 col-md-offset-1">	
					<div class="form-group">
						<label for="showtime_color" class="col-sm-4 control-label">Timeline color: </label>
						<div class="col-sm-8">
							{!! Form::select('color', showTimeColor(), null,['class' => 'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>
				
				<div class="clear"></div>
			
				<div class="col-md-11 col-md-offset-1">	
					<div class="form-group">
						<div class="col-sm-8">
							
						</div>
					</div>
				</div>
				
				<div class="clear"></div>

			</div><!-- col-md-6 -->

			<div class="col-md-12">
			
				<div class="col-md-6 nopadding" id="content1">
						
						<div class="col-md-12 row-el">	
							<div class="form-group">
								<label for="showtime_datetime" class="col-sm-4 control-label"><span>* </span>Show Date & Timings: </label>
								<div class="col-sm-8">
									{!! Form::text('dateTime', null,['id' => 'showtime_datetime', 'class' => 'form-control datetimepickers', 'value' => 'private', 'placeholder'=>'Insert date time', 'required'=>'required']) !!}
								</div>
							</div>
							<div class="clear"></div>
						</div>
				</div>
				

				<div class="col-md-12" >
					<div class="col-sm-6">
							<div id="time_confilict" class="time_confilict alert alert-danger" role="alert" style="display:none;">  </div>
					</div>
				</div>

			</div>	<!-- col-md-12 -->
			
			
		 </div><!-- form-container -->
	  </form>


@endsection

@section('scripts')
	<script type="text/javascript">
   		// Create some JSON data
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
		            'content': '<a href="{{ url('privateShowTime/'.$showtime->id.'/edit') }}">{{ $showtime->movies->title }} ( {{ $showtime->movies->duration }} min)<p class="film_small_desc"> Start Time: {{ $start_label }} End Time: {{ $end_label }}</p></a>',
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
	            $getnowdate1 = $showTime->dateTime;
	            $getnowdate2 = strtotime($getnowdate1);
	            $getnowdate = date('Y-m-d', $getnowdate2);
		    @endphp
		        //For Edit
		    $('#animateDate').val('{{$getnowdate}}');
		    go();
		});
	</script>

	<script type="text/javascript">
		var id_to_delete;

		$(".container").on('click', '.img_delete',function() {
			id_to_delete = $(this).parent().parent().find('.id_to_delete').val();
		});

		$(".modal-footer").on('click', '.btn_yes',function() {
			//console.log(id_to_delete);
			$("#delete"+id_to_delete).submit();
		});
	</script>
@endsection