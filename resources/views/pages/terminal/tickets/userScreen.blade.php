
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Cinema</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/owl.carousel.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('assets/css/jquery.mCustomScrollbar.css') }}">


  </head>

<body style="background:url('{{ asset("assets/images/uploads/movie_bg_front.jpg")}}') no-repeat center center fixed;background-size: cover;background-color: #000; color:white;">

<div class="wrapper">
  	<div class="container" style="padding-top: 15px;">
	  	<div class="col-md-12"></div>
		
		<div class="col-md-12 thankyou" style="text-align:center;display:none;position:relative!important;">
			
		</div>	
		<!-- seat_diagram -->
		  
		  
		<div class="welcome" style="text-align:center;">
			
			<img  style="margin-bottom:20px;" src="{{ asset('assets/images/welcome_logo.png') }}" />
			<div id="owl_show">
				@foreach($sliderImg as $img)
					<img src="{{ asset('assets/images/uploads/'.$img->image) }}"/>
				@endforeach
			</div>
		</div>

	  	<div class="" id="seat_diagram" style="display: block;clear: both;margin: auto;padding-top:50px;padding-right:100px;padding-left: 100px;">
				
		</div>	<!-- seat_diagram -->
		
	</div>	<!-- container -->
</div><!-- wrapper -->

<div class="container footer-container">
    
    <div class="row">
		<div class="copyright">
			<div class="col-md-6 col-sm-6">
				<p>Copyright: 2015 Designed and Developed by: WEBNET</p>
			</div>
			
			
			<div class="col-md-6 col-sm-6 powerdby">
				<a href=""><img  width="110px" src="{{ asset('assets/images/powered_logo.png') }}"/></a>
			</div><!-- col-md-4-->
			
		</div><!-- copyright -->
   </div><!-- row -->
   <!--/footer-->
</div><!-- container -->
 
<script src="{{ asset('assets/js/jquery.latest.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script> 
<script src="{{ asset('assets/js/owl.carousel.js') }}"></script> 

<script>
    $(document).ready(function() {
       var owl_product = $("#owl_show");
    	owl_product.owlCarousel({
     	autoPlay: 3000,
         itemsCustom : [
           [0, 1],
           [450, 1],
           [600, 1],
           [700, 1],
           [1000, 1],
           [1200, 1],
           [1400, 1],
           [1600, 1]
         ],
         navigation : false
    	});
    });
</script>

<script>
    $( document ).ready(function() {
		var its_seats = [];
        $('#seat_diagram').show();
		 
		setInterval(function() {
					
	 		$.post('/getSession', {'_token': '{{csrf_token()}}' },  function(session) {
	 			var id = session;
	 			if(id.length > 0){
	 				$('.welcome').hide();
	 				$('#seat_diagram').show();
		 			$.post('/getScreenSeats', {'screen_id': id, '_token': '{{csrf_token()}}' },  function(dataArray) {
				    	console.log(dataArray[1]);
			    		//$('.seats-container').html(data.screen_id);
			    		var data = dataArray[0];
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
				    	var deal;
				    	var deal_id
				    	var deal_html =  ''; //'<option selected style="color:red;" value="0">None</option>';
				    	if(dataArray[1].length != 0){
				    		deal_html = '';
				    		deal = dataArray[1];
				    		for (var i = 0; i < deal.length; i++) {
				    			deal_html += '<option style="color:green;" value="'+deal[i].id+'">'+deal[i].name+'</option>';
				    		}
				    		$('.dealSelect').html(deal_html);
				    	}
				    	var text = `<div style="margin-top:100px;"></div>`;
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
								if($.inArray(seatscode, booked_seats_array) > -1){  checked = 'checked onclick="return false" disabled'; seats_img = '{{asset('assets/images/sofa.png')}}'; thisclass='booked';}
								else if($.inArray(seatscode, advance_booked_seats_array) > -1){  checked = 'checked ="true" disabled'; seats_img = '{{asset('assets/images/sofa.png')}}'; thisclass='advance';}
								else if($.inArray(seatscode, sess_seats_array) > -1){checked = 'checked ="true"';seats_img = '{{asset('assets/images/selecting_seats.png')}}'; thisclass='normal';}
								else if($.inArray(seatscode, locked_seats_array) > -1){checked = ''; seats_img = '{{asset('assets/images/sofa.png')}}'; thisclass='normal locked';}
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

							$('#seat_diagram').html(text);
					});//ajax
				}else{
					$('.welcome').show();
					$('#seat_diagram').hide();
				}
	 		});
	    	
		}, 2000);

	});

	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
</script>

</body>