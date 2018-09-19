@extends('layouts.t_master')
@section('content')

	<div class="container main-container">
		<div class="row">
			<div class="col-md-12 main-content">
				<div class="row">
					<div class="col-md-6 nopadding paddingfive">
						<div class="row">
							<div class="col-md-12">
								<div class="movies-showing">
								
									<div class="col-md-2 col-sm-2 ">
										<p class="movie">Movies</p>
									</div>
									
									<div class="col-md-3 col-sm-3 nopadding">
										<button class="btn now-showing" type="button">
											  Now showing <span class="badge"></span>
										</button>
									</div>
									
									<div class="col-md-3 col-sm-3 nopadding">
										<button class="btn   upcoming" type="button">
											  Upcoming <span class="badge"> {{$movieStatus}} </span>
										</button>
									</div>
									
									<div class="col-md-4 col-sm-3 nopaddingleft movie_sort">
										<div class="form-group">
							                <div class='input-group date' id='datetimepicker1'>
							                    {{-- <input type='text' id="showtime_bydate" class="form-control" />
							                    <span class="input-group-addon" id="open">
							                        <span class="glyphicon glyphicon-calendar"></span>
							                    </span> --}}
							                </div>
							            </div>
									</div><!-- col-md-4 -->
									
									<div class="clear"></div>
									
									<div class="movies-detail">
											
										<ul class="movies-detail-list">

										@foreach($movies as $movie)
											@php $displayMovie = false; @endphp
											@php $showTimes = getMovieShowTimes($movie->id); @endphp
											@foreach($showTimes as $showTime)
												@php
													$tdx=date("Y/m/d h:i");
													$todayDate = (strtotime($tdx));
													$thisDate = strtotime($showTime->dateTime); 
													if(($todayDate == $thisDate) || ($thisDate > $todayDate)){
														$displayMovie = true;
													}
												@endphp
											@endforeach
											@if($displayMovie == true)
												<li class="movie_list">
													<div class="col-md-7 col-sm-7 movie-img nopadding"><img src="{{ asset('assets/images/movie-img.png') }}"/>
														<div class="movie-title nopadding"><p>Movie Name: <strong>{{$movie->title}}</strong></p></div>
													</div>
													<div class="col-md-5 col-sm-5 nopadding select-movie">
														<button class="btn btn-default movie-select-btn" type="button" >
															  <span><img  src="{{ asset('assets/images/white_plus.png') }}"/></span> Select your movie 
														</button>
														<button class="btn btn-default movie-detail-btn" type="button" >
															 Details 
														</button>
													</div>
													<div class="clear"></div>
													
													<div class="movie-venue col-md-12 nopadding item_height" data-status="1">
														<ul class="movie-venue-list">
															<li>
																	<div class="venue-head">
																	<div class="col-md-2 col-sm-2 venue">Time</div>
																	<div class="col-md-2 col-sm-2 venue">Screen</div>
																	<div class="col-md-2 col-sm-2 venue">Sold</div>
																	<div class="col-md-2 col-sm-2 venue">Available</div>
																	<div class="col-md-2 col-sm-2 vanue-plus venue"><img src="{{ asset('assets/images/white_plus.png') }}"></div>
																</div>
															</li>
															@foreach($showTimes as $showTime)
																@php
																	$tdx=date("Y/m/d h:i");
																	$todayDate = (strtotime($tdx));
																	$thisDate = strtotime($showTime->dateTime);
																@endphp
																@if(($todayDate == $thisDate) || ($thisDate > $todayDate))
																	@php
																	 $showStartTime = $showTime->dateTime;
																	 $startTime =  date('d-M h:i A', strtotime($showStartTime));
																	 $weekDay =  date('l', strtotime($showStartTime));
																	 $showTime_id = $showTime->id;

																	 $iniTotalBookedSeats = 0;
																	 $totalBookedSeats = 0;
																	 $allBookedSeats = 0;
																	 $allRemainingSeats = 0;

																	 $booked_seats = bookedSeatsQty($showTime_id);
																	@endphp

																	 @foreach ($booked_seats as $key => $value)
																	 	@php
																	 	 $iniTotalBookedSeats = $value->seatQty;
																	 	 $totalBookedSeats += $iniTotalBookedSeats;
																	 	@endphp
																	 @endforeach

																	@php
																	 $totalBookedSeats;
																	 $totalSeats = $showTime->screens->totalSeats;
																	 $allRemainingSeats = $totalSeats - $totalBookedSeats;
																	@endphp
																<li>
																	<div class="venue-cinema">
																		<div class="col-md-2 col-sm-2 venue cinema-name-odd"><p> {{$startTime}} </p><p> {{$weekDay}} </p></div>
																		<div class="col-md-2 col-sm-2 venue"><p style="line-height: 34px;"> {{$showTime->screens->name}} </p></div>
																		<div class="col-md-2 col-sm-2 venue"><p style="line-height: 34px;"> {{$totalBookedSeats}} </p></div>
																		<div class="col-md-2 col-sm-2 venue"><p style="line-height: 34px;"> {{$allRemainingSeats}} </p></div>
																		<div class="col-md-2 col-sm-2 venue  vanue-plus">
																			<button class="btn btn-default book-ticket-btn screen_id_btn" id="book_btn{{$showTime->id}}" data-toggle="modal" data-target="#fsModal" @if($allRemainingSeats == 0)style="background-color:red!important;"@endif> @if($allRemainingSeats==0)All Booked @else Book a Ticket @endif </button>
																			<input type="hidden" class="screen_id" value="{{$showTime->id}}">
																		</div>
																	</div>
																</li>
																@endif
															@endforeach
														</ul>
													</div>
												</li>
											@endif
										@endforeach
										</ul>
									</div>
									
								</div><!-- /movies-showing -->
							</div><!-- col-md-12 -->
							
						</div><!-- row -->
					</div><!-- col-md-6-->
					
					<div class="col-md-6 padding5">
						<div class="deal-bg" id="terminal">
							<div class="col-md-12 col-sm-12 add-deals-head">
								<div class="col-md-9 col-sm-9 nopadding">	
									<p>Book Tickets in Advanced  (on particular basis)</p>
								</div><!-- col-md-6-->
								<div class="col-md-3 col-sm-3 nopadding">	
									<div class="navbar-right dropdown settings ">
									  <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img  src="{{asset('assets/images/settings.png')}}"/></a>
									  <ul class="dropdown-menu">
										<li><a href="#">HTML</a></li>
										<li><a href="#">CSS</a></li>
										<li><a href="#">JavaScript</a></li>
									  </ul>
									</div>
								</div><!-- col-md-6-->
								
							</div><!-- add-deals-head-->
							
							<div class="add-deals-desc">
								<div class="col-md-12 col-sm-12" style="padding:5px;">
									<p>Booking Description</p>
								</div><!-- col-md-9-->
							</div><!-- col-md-3-->
							<div class="terminal-adv add-deals-item"></div><br><br>
						
						</div><!-- deal-bg-->
						
						<div class="clear"></div>
							
						<div class="function-bg">
						
							<div class="col-md-3 col-sm-3 function-bg-br">
								<img width="25px" id="all_delete" class="img-responsive" src="{{asset('assets/images/delete_icon.png')}}"/>
								 Reset
							</div>	
						
						</div><!-- function-bg-->
						
						<div class="clear"></div>
							
						<div class="total-amount">
							<div class="col-md-5 col-sm-6 nopadding">
								<p class="total-amount-label">Total Amount:<br/>
								<span>Inc: GST</span></p>
							</div><!-- col-md-5-->
							
							<div class="col-md-7 col-sm-6">
								<p class="total-amount-value">Rs. 00.00<br/>
								
								
								<span>- 20% PKR</span></p><br/>
								<input type="hidden" id="ticket_total" value="">
							</div><!-- col-md-7-->
						</div><!-- total-amount-->
						
						
						<div class="clear"></div>
						
						<div class="ticket-save">
							<div class="col-md-6 col-sm-6">
								
							</div>
									
							<div class="col-md-6 col-sm-6 save-cancel">
							<a href="{{url('/advBooking')}}">Cancel </a>
								<button class="btn btn-default save-btn" id="final_booking" type="button" >
									Save Changes
								</button>
							</div>
		
						</div><!-- ticket-type-btn-->
						<div id="saved" class="alert alert-success" role="alert" style="display:none;"> Booking added Sucessfully </div>
					</div><!-- col-md-5-->
					
					
				</div><!-- row -->
				
				<div class="clear"></div>
			
		    </div><!-- col-md-10 -->
	   </div><!-- row -->
	</div><!-- /main container -->


	<!-- modal -->
	<div id="fsModal" class="modal animated bounceIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content" style="padding-top: 0px;">
				<form method="post" action="#">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 header-seat">
								<div class="row">
									<div class="col-sm-6 plan-buttons">
										<button class="btn btn-default empty" type="button">
											<span class="badge" id="empty_badge">0 </span> Seat Empty 
										</button>

										<button class="btn btn-default booked" type="button">
											<span class="badge" id="selected_badge">0 </span> Seat Selected 
										</button>

										<button class="btn btn-default selecting" type="button">
											<span class="badge" id="selecting_badge">0 </span> Seat Selecting 
										</button>
										<div class="clearfix"></div>
										
										<div>
											<div class="col-sm-4 plan-buttons">
												<div class="form-group" style="margin: 0px;">
													<label>
														<input type="radio"  name="ticket_adult" class="ticket_adult" value="yes" checked>
														Adult 
													</label>
													<label>
														<input type="radio"  name="ticket_adult" class="ticket_adult" value="no">
															 Child 
													</label>
												</div>
											</div>
											
											<div class="col-sm-4 complimentary plan-buttons isComp" >
												<div class=" complimentary">
													<label>
														<input type="checkbox"  id="complimentary" name="complimentary" value="yes" >
														Complimentary
													 </label>
												</div>						
											</div>
											
											<div class="col-sm-3  plan-buttons">
												<div class=" ">
													<label>
														<input type="checkbox"  id="reprint" name="reprint" value="yes">
														Reprint
													 </label>
												</div>						
											</div>
										</div >
									</div>

									<div class="col-sm-3 plan-buttons nopadding" >
										<div class="colors_indicator">Selected<span class="selected_box"></span> Booked<span class="booked_box"></span> Hold<span class="hold_box"></span></div>
									</div>
									
									<div class="col-sm-3" style="text-align:right">
										<button class="btn btn-secondary seats_btn" id="seats_btn"  >Save </button>
										<button type="button" class="btn btn-secondary seats_btn_cancel">Cancel </button>
										<a href="#" type="button" class="btn btn-secondary " id="reprint_submit" style="display:none;">Re-Print </a>
									</div>
								</div>
							</div>
					    </div>
					</div>
					<div class="container seats-container" id="seats-container"> 
					</div>
				</form>
		    </div>
		</div>
	</div>

@endsection

@section('scripts')

	<script type="text/javascript">

		$( document ).ready(function() {

			var diabled_popup = $('.is_popup').val();
			var refresh = true;

			setInterval(function() {
				if(refresh){
					window.location.reload(1);
				}
			  // After 5 secs
			}, 7000);

		if(diabled_popup == 'no'){
			var l_width = screen.availWidth;
			var l_height = screen.availHeight;
			var myWindow1 = window.open("user_booking_screen.php", "Cinema", "width="+l_width+",height="+l_height);
		}

		$('#myTabs a').click(function (e) {
			  e.preventDefault()
			  $(this).tab('show')
		});

		var now_showing = $(".movie_list").size();
		$(".now-showing .badge").html(now_showing);


		$( ".movie-detail-btn" ).click(function() {
			if(refresh == false){
				refresh = true;
			}else{
				refresh = false;
			}
		  	$(this).parent().parent().find(".movie-venue").toggle("slow");
		});


		$( ".movie-select-btn" ).click(function() {
			if(refresh == false){
				refresh = true;
			}else{
				refresh = false;
			}
			
			$(this).parent().parent().find(".movie-venue").toggle("slow");
		});

		
		$(".item_height").mCustomScrollbar({
			setHeight:200,
			theme:"inset-2-dark"
		});

		
		$(".movies-showing").on('click', '.book-ticket-btn',function(event) {
	    	event.preventDefault();
	    	var id = $(this).next('.screen_id').val();
	    	$.post('/getScreenSeats', {'screen_id': id, '_token': '{{csrf_token()}}' },  function(data) {
		    	//console.log(data);
	    		//$('.seats-container').html(data.screen_id);
		    	var total_rows =  JSON.parse(data.screens.rows)
		    	var total_column = JSON.parse(data.screens.columns);
		    	var rows = total_rows;
		    	var rowcolumn = total_column;
		    	var screen_id = JSON.parse(data.screen_id);
		    	var booked_seats_array = [];
		    	for(var i=0; i < data.bookings.length; i++){
		    		booked_seats_array.push(data.bookings[i].seatNumber);
		    	}
		    	//console.log(booked_seats_array.length);
		    	$('#selected_badge').text(booked_seats_array.length);
		    	var advance_booked_seats_array = [];
		    	for(var i=0; i < data.advance_bookings.length; i++){
		    		var adv_seats = JSON.parse(data.advance_bookings[i].seatNumber);
		    		var advBookedSeats = JSON.parse(data.advance_bookings[i].bookedSeatNumber);
		    		if(advBookedSeats != null){
		    			for(var x=0; x < advBookedSeats.length; x++){
		    				advance_booked_seats_array.push(advBookedSeats[x]);
		    			}
		    		}else{
		    			for(var x=0; x < adv_seats.length; x++){
		    				advance_booked_seats_array.push(adv_seats[x]);
		    			}
		    		}
		    	}
		    	var sess_seats_array = [];
		    	for(var i=0; i < data.seats.length; i++){
		    		if(data.seats[i].user_id == {{Auth::user()->id}}){
		    			sess_seats_array.push(data.seats[i].seatNumber);
		    		}
		    	}
		    	
		    	var showtime_id = JSON.parse(data.id);
		    	var locked_seats_array = [];
		    	for(var i=0; i < data.seats.length; i++){
		    		locked_seats_array.push(data.seats[i].seatNumber);
		    	}
		    	var movie_id = data.movie_id;
		    	if(data.complimentrySeat == 0){
		    		$('.isComp').hide();
		    	}else{
		    		$('.isComp').show();
		    	}
		    	var text = '<div><div class="alert alert-danger" id="locked_warning" style="display:none;" role="alert">This Seat has already selected!</div><div><input type="hidden" id="selected_show" value="'+data.id+'"><input type="hidden" id="ticket_type" value="'+data.tickets.type+'"><input type="hidden" id="selected_movie_title" value="'+data.movies.title+'"><input type="hidden" id="selected_movie_id" value="'+data.movies_id+'"><input type="hidden" id="selected_dist_id" value="'+data.movies.distributer_id+'"> <input type="hidden" id="selected_showtime_key" value="'+data.key+'">';
				text += '<div class="col-sm-12"><div class="col-sm-4"><strong>Movie: <span style="color: #B90100;">'+data.movies.title+'</span></strong></div><div class="col-sm-4"><strong>Show Time: <span style="color: #B90100;">'+data.dateTime+'</span></strong></div><div class="col-sm-4"><strong>Screen: <span style="color: #B90100;">'+data.screens.name+'</span></strong></div></div><br/><br/>';
		    	var z;
		    	var indexcolumn;
		    	var offsetclass = '';
		    	var checked='';
		    	var thisclass ='';
		    	var seats_img = '{{url('assets/images/empty_seats.png')}}';
		    	for	(z = 0; z < rows.length; z++) {
						var currentrow = rows[z];
						var columnlenght = rowcolumn[z];
						text +='<div class="row flex-seat">';
						for	(indexcolumn = 1; indexcolumn <= columnlenght; indexcolumn++) {
						if((screen_id==27)&&(currentrow == 'A') && (indexcolumn == 5) ){offsetclass = 'col-sm-offset-3';}else{offsetclass ='';}
						var seatscode = rows[z] + '-' + indexcolumn;
						if($.inArray(seatscode, booked_seats_array) > -1){  checked = 'checked onclick="return false" disabled'; seats_img = '{{asset('assets/images/selected_seats.png')}}'; thisclass='booked';}
						else if($.inArray(seatscode, advance_booked_seats_array) > -1){  checked = 'checked ="true" disabled'; seats_img = '{{asset('assets/images/advance_seats.png')}}'; thisclass='advance';}
						else if($.inArray(seatscode, sess_seats_array) > -1){checked = 'checked ="true"';seats_img = '{{asset('assets/images/selecting_seats.png')}}'; thisclass='normal';}
						else if($.inArray(seatscode, locked_seats_array) > -1){checked = ''; seats_img = '{{asset('assets/images/hold_seats.png')}}'; thisclass='normal locked';}
						else{checked = '';seats_img = '{{asset('assets/images/empty_seats.png')}}'; thisclass='normal';}
						text +='<div class="col-sm-1 seats nopadding '+ offsetclass +'">';
						text += '<div class="checkbox">';
						text += '<label>';
						text += '<img src="'+seats_img+'">';
						text += '<input type="checkbox"  name="seats[]" value="' + rows[z] + '-' + indexcolumn + '" '+checked+' class="' +thisclass+'">';
					    text += ''+rows[z] + '-' + indexcolumn+'';
					    text += '</label>';
					    text += '</div>';
					    text += '</div>';
						}
					    text += '</div>';
					}

					$('#seats-container').html(text);
			});//ajax
		});//button click



		$("#seats-container").on('click', '.seats input[type="checkbox"]',function() {
			if($('#reprint').is(":not(:checked)")){
				$("#hack").show(0);
				//$(".seats input[type='checkbox']").attr("disabled","disabled");
			 	var imgsselecting = $("img[src='{{asset('assets/images/selecting_seats.png')}}']").length;
				var imgempty = $("img[src='{{asset('assets/images/empty_seats.png')}}']").length;
			 	var show_id = $('#selected_show').val();
			 	var This = $(this);
			 	var current_val = $(this).val();
			 	var currentelement = $(this);
			 	var initial_seats = [];
				var c_seats = [];
				var ticket_adult = $("input[name='ticket_adult']:checked").val()
				var allow_comp = 0;
				if($('#complimentary').is(":checked")){
		            allow_comp = 1;
		       	}else{
		       	   	allow_comp = 0;
		       	}
			 	//console.log(currentelement.context.className);
			 	if (this.checked) {
					setTimeout(function(){
					  if( $("#hack").is(':visible') ){
						  if($(This).is(':checked')){
							  $("#hack").hide(0);
							  $(This).prop( "checked", false );
							  $(This).trigger( "click" );
						  }else{
							  $("#hack").hide(0);
							  $(This).trigger( "click" );
						  }
					  }
					},5000);
		    		$.post('getAllSeat', {'showTime_id': show_id, 'currentSeatNumber': current_val, '_token': '{{csrf_token()}}' }, function(data4){
				    	if(data4 == true){
				    		currentelement.addClass('uncheck');
				    		This.parent().find('img').attr("src", "{{asset('assets/images/hold_seats.png')}}");
				    		$('.uncheck').attr('checked', false);
							This.addClass('locked');	    		
				    		if(imgsselecting != 0){$('#selecting_badge').text(imgsselecting-1);}
	        				$('#locked_warning').text('This Seat has already selected!');
				    		$('#locked_warning').fadeIn('slow').delay(1000).fadeOut('slow');
							$("#hack").hide(0);
							//$(".seats input[type='checkbox']").removeAttr("disabled");
				    		return false;
						}else{
				  			$('#locked_warning').hide();
				    		$('.uncheck').attr('checked', true);
				    		currentelement.removeClass('uncheck');
				    		$.post('holdAdvSeats', {'showTime_id': show_id, 'currentSeatNumber': current_val,'ticket_adult':ticket_adult,'allow_comp':allow_comp ,'_token': '{{csrf_token()}}'}, function(data){
								//console.log(data);
								This.parent().find('img').attr("src", "{{asset('assets/images/selecting_seats.png')}}");
								This.parent().find('img').css('opacity', '1');
								This.addClass('current');
								This.removeClass('locked');
								$('#selecting_badge').text(imgsselecting+1);
								$('#empty_badge').text(imgempty-1);
								$("#hack").hide(0);
								//$(".seats input[type='checkbox']").removeAttr("disabled");
				    		});
				    		$("#hack").hide(0);
						}
			    	});
		    	}else{
		    		$("#hack").show(0);
			    	//console.log('when uncheck');
			    	setTimeout(function(){
					  if( $("#hack").is(':visible') ){		 
						  if(!$(This).is(':checked')){
							  $("#hack").hide(0);
							  $(This).prop( "checked", true );
							  $(This).trigger( "click" );
						  }else{
							  $("#hack").hide(0);
							  $(This).trigger( "click" );
						  }
					  }
					}, 5000);
		    		$.post('deleteAdvSeat', {'showTime_id': show_id,'currentSeatNumber': current_val, '_token': '{{csrf_token()}}'}, function(data){
						//console.log(data);
						This.parent().find('img').attr("src", "{{asset('assets/images/empty_seats.png')}}");
						This.removeClass('current');
						$('#selecting_badge').text(imgsselecting-1);
						$('#empty_badge').text(imgempty+1);
						$("#hack").hide(0);
			    	});
					$(".seats input[type='checkbox']").removeAttr("disabled");
				}
			}
	  	});

		//release advance checkbox
		$("#release_booked_s").click(function () {
		
	        if ($(this).is(':checked')) {
	            $("#seats-container .advance").each(function () {
	                $(this).prop("checked", false);
	                $(this).attr("disabled", false);
	            });
				$("#seats-container .normal").each(function () {
				  $(this).attr("disabled", true);
				});
			} else {
	            $("#seats-container .advance").each(function () {
	                $(this).prop("checked", true);
	                $(this).attr("disabled", true);
	            });
				$("#seats-container .normal").each(function () {
	                $(this).attr("disabled", false);
				});
	        }
	    }); //release advance checkbox
		
		
		$("#reprint").click(function () {

			if ($(this).is(':checked')) {
				$("#seats-container .booked").each(function () {
	                $(this).prop("checked", false);
	                $(this).attr("disabled", false);
					$(this).attr('onclick','')
	            });
			
				$("#seats-container .normal").attr("disabled", true);
				$(".ticket_adult").attr("disabled", true);
				$("#complimentary").attr("disabled", true);
				$("#seats_btn").hide();
				$(".seats_btn_cancel").hide();
				$("#reprint_submit").show();
			} else {
				$("#seats-container .booked").each(function () {
					$(this).prop("checked", true);
					$(this).attr("disabled", true);
					$(this).attr('onclick','return false')
				});
				
				$("#seats-container .normal").attr("disabled", false);
				$(".ticket_adult").attr("disabled", false);
				$("#complimentary").attr("disabled", false);
				$("#seats_btn").show();
				$(".seats_btn_cancel").show();
				$("#reprint_submit").hide();
			}
		}); //reprint

		var reprint = [];
		$('#reprint_submit').on('click', function(){
			var show_id = $('#selected_show').val();
			if ($('#reprint').is(':checked')) {
				$("#seats-container .booked").each(function () {
	                if($(this).is(':checked')){
	                	reprint.push($(this).val());
	                }
	            });
	           // console.log(JSON.stringify(reprint));
				$('.showid').val(show_id);
				$('.seatNum').val(JSON.stringify(reprint));
				$('.reeprint').val('reprint');
				$('.directPrint').val('');
				$('.send_booking_id').submit();
			};
		});
		 

		$(".seats_btn_cancel").click(function(){
			var show_id = $('#selected_show').val();
			$("#hack").show();
			setTimeout(function(){
			  if( $("#hack").is(':visible') ){
				$("#hack").hide(0);
			  }
			},5000);
			$.post('cancelAllSelectedSeats', {'showTime_id': show_id, '_token': '{{csrf_token()}}' }, function(data4){
				if(data4){
					$("#hack").hide();
					$('#fsModal').modal('hide');
					$('.book-ticket-btn').prop('disabled', false);
					$('.terminal-adv').html('');
			  		$('.total-amount-value').text('Rs. 00.00');
				}
			})
			setTimeout(function(){
			  if( $("#hack").is(':visible') ){		 
				  $("#hack").hide();
			  }
			}, 3000);
		});	
		
		$('.container').on('click','#seats_btn',function(e){
			e.preventDefault();
			setTimeout(function(){
					  if( $("#hack").is(':visible') ){
						$("#hack").hide(0);
					  }
					},5000);
			var posted_seats = [];
			$.each($(".seats input[type='checkbox']:not(:disabled)"), function(){  
	        	if (this.checked) {       
					if (! $( this ).hasClass( "locked" ) ) {
						posted_seats.push($(this).val());
					}
				}
	        });
	        //console.log(posted_seats.length);
	        if(posted_seats.length == 0){
	        	$(this).removeAttr('data-dismiss');
	        	//console.log('zero');
	        	$('#locked_warning').text('Select Seat first!');
	        	$('#locked_warning').fadeIn('slow').delay(1000).fadeOut('slow');
	        }else{
	        	$('#hack').show();
	        	$(this).attr('data-dismiss', 'modal');

	        	$("#release_booked_s").prop("checked", false);
				var shw_id = $('#selected_show').val();
				var ticket_adult = $("input[name='ticket_adult']:checked").val()
				var movie_title = $('#selected_movie_title').val();
				var allow_comp = "no";

				//console.log(posted_seats);
					
		        if($('#complimentary').is(":checked")){
		            allow_comp = "yes";
		       	}else{
		       	   	allow_comp = "no";
		       	}
		       
				var qty = 1;
				$.post('/holdAdvBookingAndGetSeats', {'showTime_id': shw_id, '_token': '{{csrf_token()}}' },  function(advSeat) {
					//console.log(advSeat);
					$('.terminal-adv').html('');
					var seatToBook = '';
					var seatNumbers = [];
					var adultQty = 0;
					var childQty = 0;
					var comp = 0;
					for(var i=0; i<advSeat.length; i++){
						seatNumbers.push(advSeat[i].seatNumber);
						seatToBook += advSeat[i].seatNumber+', ';
						if(advSeat[i].ticketType == 'adult price' && advSeat[i].isComp == 0 ){
							adultQty++;
						}
						if(advSeat[i].ticketType == 'child price' && advSeat[i].isComp == 0 ){
							childQty++;
						}
						if(advSeat[i].isComp == 1){
							comp++;
						}
					}
					//console.log(seatNumbers);
					var adTo = advSeat[0].show_times.tickets.adultPrice * adultQty;
					var chTo = advSeat[0].show_times.tickets.childPrice * childQty;
					var sum = +adTo + +chTo;

					var terminal_text =` 
						<div class="booking_form">
							<div class="col-md-offset-1 col-md-11">
								<div class="form-group">
									<label for="customer_name" class="col-sm-4 control-label"><span>*</span> Customer Name: </label>
									<div class="col-sm-7">
										<input type="text" name="name" id="customer_name" value="" class="form-control name" required>
									</div>
								</div>
							</div>
							<div class="clear"></div>
							
							<div class="col-md-offset-1 col-md-11">
								<div class="form-group">
									<label for="customer_phone" class="col-sm-4 control-label"><span>*</span>  Phone Number: </label>
									<div class="col-sm-7">
										<input type="text" name="phoneNo" id="customer_phone" value="" class="form-control phoneNo" required>
									</div>
								</div>
							</div>
							<div class="clear"></div>

							<div class="col-md-offset-1 col-md-11">
								<div class="form-group">
									<label for="customer_email" class="col-sm-4 control-label"> Email: </label>
									<div class="col-sm-7">
										<input type="text" name="email" id="customer_email" value="" class="form-control email" >
									</div>
								</div>
							</div>
							<div class="clear"></div>

							<div class="col-md-offset-1 col-md-11">
								<div class="form-group">
									<label for="customer_movie" class="col-sm-4 control-label"><span>*</span> Movie: </label>
									<div class="col-sm-7">
										<input type="text" name="movie" id="customer_movie" value="`+advSeat[0].show_times.movies.title+`" class="form-control" readonly required>
									</div>
								</div>
							</div>
							<div class="clear"></div>

							<div class="col-md-offset-1 col-md-11">
								<div class="form-group">
									<label for="customer_seats" class="col-sm-4 control-label"><span>*</span> Seats Numbers: </label>
									<div class="col-sm-7">
									<textarea class="form-control" readonly required>`+seatToBook+`</textarea>
										
										<span style="display:none;" class="seatNumbers">`+JSON.stringify(seatNumbers)+`</span>
									</div>
								</div>
							</div>
							<div class="clear"></div>

							<div class="col-md-4 col-sm-4 add-deal-item-value" style="text-align:center;">
								 <b>Adult Tickets</b><br><br>
								 <p>`+advSeat[0].show_times.tickets.adultPrice+` x `+adultQty+`</p>
								 <input type="hidden" name="adultPrice" class="adultPrice" value="`+advSeat[0].show_times.tickets.adultPrice+`"/>
								 <input type="hidden" name="adultQty" class="adultQty" value="`+adultQty+`"/>
							</div>
							<div class="col-md-4 col-sm-4 add-deal-item-value" style="text-align:center;">
								 <b>Child Tickets</b><br><br>
								 <p>`+advSeat[0].show_times.tickets.childPrice+` x `+childQty+`</p>
								 <input type="hidden" name="childPrice" class="childPrice" value="`+advSeat[0].show_times.tickets.childPrice+`"/>
								 <input type="hidden" name="childQty" class="childQty" value="`+childQty+`"/>
							</div>
							<div class="col-md-4 col-sm-4 add-deal-item-value" style="text-align:center;">
								 <b>Complimentary</b><br><br>
								 <p>`+comp+`</p>
								 <input type="hidden" name="comp" class="comp" value="`+comp+`"/>
							</div>

							<div class="col-md-offset-1 col-md-11">
								<div class="form-group">
									<label for="customer_seats_qty" class="col-sm-4 control-label"><span>*</span> Total Quantity: </label>
									<div class="col-sm-7">
										<input type="text" name="seatQty" id="customer_seats_qty" value="`+advSeat.length+`" class="form-control seatQty" readonly required>
									</div>
								</div>
							</div>
							<div class="clear"></div>

							<div class="col-md-offset-1 col-md-11">
								<div class="form-group">
									<label for="customer_amount" class="col-sm-4 control-label"><span>*</span> Booking Amount: </label>
									<div class="col-sm-7">
										<input type="text" name="amount" id="customer_amount" value="`+sum+`" class="form-control amount" readonly required>
									</div>
								</div>
							</div>
							<input type="hidden" value="`+advSeat[0].show_times.movie_id+`" class="movie_id">
							<input type="hidden" value="`+advSeat[0].show_times.movies.distributer_id+`" class="dist_id">
							<input type="hidden" value="`+advSeat[0].show_times.id+`" class="showTime_id" readonly required>
							<div id="booking_confilict" class="alert alert-danger" role="alert" style="display:none;clear: both;width: 80%;margin: auto;padding: 10px;margin-top: 10px;"> Kindly complete this booking detail first! 
							</div>
						</div>`;
					$('.terminal-adv').html(terminal_text);
			  		$('.total-amount-value').text('Rs. '+parseFloat(sum).toFixed(2));
				  	$('.book-ticket-btn').prop('disabled', true);
				  	$('#book_btn'+shw_id).prop('disabled', false);
				  	//subtotalcalc();
				  	$('.expression1').focus();
				  	$('#hack').hide();
				});
		 		//delete ticket terminal list
	        }			    
		});
				
	 	//all delete function
	 	$("#all_delete").click(function(){
			$('.seats_btn_cancel').trigger('click');
		});


		$("#final_booking").click(function(){
			if($('.terminal-adv').find('.seatQty').val() != undefined){
				//$("#hack").show();
				setTimeout(function(){
				  if( $("#hack").is(':visible') ){
					$("#hack").hide(0);
				  }
				},5000);

				var name = $('.terminal-adv').find('.name').val();
				var phoneNo = $('.terminal-adv').find('.phoneNo').val();
				var email = $('.terminal-adv').find('.email').val();
				var showTime_id = $('.terminal-adv').find('.showTime_id').val();
				var seatNumbers = $('.terminal-adv').find('.seatNumbers').text();
				var amount = $('.terminal-adv').find('.amount').val();
				var seatQty = $('.terminal-adv').find('.seatQty').val();
				var movie_id = $('.terminal-adv').find('.movie_id').val();
				var dist_id = $('.terminal-adv').find('.dist_id').val();
				var adultPrice = $('.terminal-adv').find('.adultPrice').val();
				var adultQty = $('.terminal-adv').find('.adultQty').val();
				var childPrice = $('.terminal-adv').find('.childPrice').val();
				var childQty = $('.terminal-adv').find('.childQty').val();
				var comp = $('.terminal-adv').find('.comp').val();

				if(name == '' || phoneNo == ''){
					$('#booking_confilict').fadeIn('slow').delay(1000).fadeOut('slow');
				}else{
					$.post('bookAdvTickets', {'showTime_id': showTime_id, 'name': name, 'phoneNo': phoneNo, 'email': email, 'seatNumbers': seatNumbers, 'amount': amount, 'seatQty': seatQty, 'movie_id': movie_id, 'dist_id': dist_id, 'adultPrice': adultPrice, 'adultQty': adultQty, 'childPrice': childPrice, 'childQty': childQty, 'comp': comp, '_token': '{{csrf_token()}}' }, function(done){
						//console.log(done)
						if(done){
							$('.book-ticket-btn').prop('disabled', false);
							var hhml = `
								<br><br>
								<h1 align="center">Successfully Booked</h1>
							`;
							$('.terminal-adv').html(hhml);
						   	$("#hack").hide();
						}
					});
				}
				
			}
	 	});  //final_booking


		function subtotalcalc (event) {
	    	//alert('Press Hit Button');
	    	// Sub Total All Amount Table and save in subtotal variable
	    	var subtotal = 0;
		    $('.terminal_m_sum').each(function() {
		        subtotal += parseFloat($(this).val());
		    });
		    // Display Value to Sub Total Amount
		    $(".total-amount-value").text('Rs.'+parseFloat(subtotal).toFixed(2));
		    $("#ticket_total").val(parseFloat(subtotal).toFixed(2));
		}

		$(".calculate").click(function(){
			 var returnamount =  $(".expression1").val() - $("#ticket_total").val();
			 $(".expression2").val(returnamount);
		});
		subtotalcalc();
		});//end document ready

		$(window).unload(function() {
			$("#hack").hide();
		    $(".seats_btn_cancel" ).trigger( "click" );
		   	$("#hack").hide();
		});

		window.onbeforeunload = function(event){
		    // $(".seats_btn_cancel" ).trigger( "click" );
		    // $("#hack").hide();
		};
	</script>

@endsection