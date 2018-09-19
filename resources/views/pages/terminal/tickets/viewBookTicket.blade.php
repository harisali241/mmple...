<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>A5</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="">

  <!-- Load paper.css for happy printing -->
  <style type="text/css">
    @page { margin: 0 }
  body { margin: 0 }
  .sheet {
    margin: 0;
    overflow: hidden;
    position: relative;
    box-sizing: border-box;
    page-break-after: always;
  }

  /** Paper sizes **/
  body.A3               .sheet { width: 297mm; height: 419mm }
  body.A3.landscape     .sheet { width: 420mm; height: 296mm }
  body.A4               .sheet { width: 210mm; height: 296mm }
  body.A4.landscape     .sheet { width: 297mm; height: 209mm }
  body.A5               .sheet { width: 148mm; height: 209mm }
  body.A8               .sheet { width: 50.8mm; height: 90.83mm }
  body.A5.landscape     .sheet { width: 210mm; height: 127mm }
  body.letter           .sheet { width: 216mm; height: 279mm }
  body.letter.landscape .sheet { width: 280mm; height: 215mm }
  body.legal            .sheet { width: 216mm; height: 356mm }
  body.legal.landscape  .sheet { width: 357mm; height: 215mm }

  /** Padding area **/
  .sheet.padding-10mm { padding: 10mm }
  .sheet.padding-30mm { padding: -10mm }
  .sheet.padding-15mm { padding: 15mm }
  .sheet.padding-20mm { padding: 20mm }
  .sheet.padding-25mm { padding: 25mm }

  /** For screen preview **/
  @media screen {
    body { background: #e0e0e0 }
    .sheet {
      background: white;
      box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
      margin: 5mm auto;
    }
  }

  /** Fix for Chrome issue #273306 **/
  @media print {
            body.A3.landscape { width: 420mm }
    body.A3, body.A4.landscape { width: 297mm }
    body.A4, body.A5.landscape { width: 210mm }
    body.A5                    { width: 148mm }
    body.A8                    { width: 148mm }
    body.letter, body.legal    { width: 216mm }
    body.letter.landscape      { width: 280mm }
    body.legal.landscape       { width: 357mm }
  }

</style>

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A8 }</style>
  <style type="text/css">

    .con{
      	z-index: 999;
       	-ms-transform: rotate(90deg); /* IE 9 */
   		-webkit-transform: rotate(90deg); /* Safari 3-8 */
    }
    .con.text1 {
         margin-left: 123px;
    margin-top: 84px;
    }
    .con.text2 {
         margin-left: 90px;
    margin-top: -18px;
    }
    .con.text3 {
        margin-left: 63px;
    margin-top: -21px;
    }
    
    .con.text4 {
      margin-left: 33px;
    margin-top: -21px;
    }
    .con.text5 {
        margin-left: 4px;
    margin-top: -20px;
    }
    .con.text6 {
        margin-left: 121px;
    margin-top: 49px;
    }
    .con.text7 {
          margin-left: 75px;
    margin-top: -40px;

    }
    .con.text8 {
      margin-left: 77px;
        margin-top: 53px;
    }
    .con.text9 {
        margin-left: 77px;
    margin-top: 64px;

    }
    .con.text10 {
    margin-left: 44px;
    margin-top: -141px;
    }
.con.text11 {
    margin-left: 132px;
    margin-top: 77px;
    }
.con.text12 {
    margin-left: 118px;
    margin-top: -17px;
    }
.con.text13 {
    margin-left: 105px;
    margin-top: -17px;
    }
	
	
	@media print{
    	.submitBtn{
        display:none;
      }
  }

</style>

</head>
<body class="A8">
@foreach($bookings as $booking)
	<section class="sheet padding-30mm">
		<div class="new" style="margin-top:-16px;">
		    <img src="{{asset('asset/ticketresizedsds.jpg')}}" style="  opacity: 0; margin-left: 64px;
		    margin-top: -24px;">
		    <h6 class="con text1" style="font-size: 10px; ">{{ $booking->screens->name }}</h6>
		    <h6 class="con text2" style="font-size: 10px; ">{{ $booking->seatNumber }}</h6>
		    <h6 class="con text3" style="font-size: 10px; ">{{ date('h:i', strtotime($booking->showtime)) }}</h6>
		    <h6 class="con text4" style="font-size: 10px; ">{{ date('d/m/y', strtotime($booking->showtime)) }}</h6>
		    <h6 class="con text5" style="font-size: 10px; text-transform:uppercase;">{{ $booking->movies->title }}</h6>
		    <h6 class="con text6" style="font-size: 8px; ">{{ $booking->screens->name }}{{ ' | Rs. '.$booking->price }}</h6>
		    <h6 class="con text7" style="font-size: 10px; ">{{ date('h:i', strtotime($booking->showtime)) }}</h6>
		    <h6 class="con text8" style="font-size: 10px; ">{{ date('d/m/y', strtotime($booking->showtime)) }}</h6>
		    <h6 class="con text9" style="font-size: 10px; ">{{ $booking->seatNumber }}</h6>
		    <h6 class="con text10" style="font-size: 10px; text-transform:uppercase;">{{ $booking->movies->title }}</h6>
			<h6 class="con text11" style="font-size: 7px; ">{{ $booking->show_times->key }}</h6>
			<h6 class="con text12" style="font-size: 7px; ">{{ date("d/m/Y h:s:a", time()) }}></h6>
			<h6 class="con text13" style="font-size: 7px; ">{{ Auth::user()->username }}</h6>

		</div>
	</section>
@endforeach


</body>
<script src="{{ asset('assets/js/jquery.latest.js') }}"></script>
	
	@if($print == 'printIT')
		<script>
			$( document ).ready(function() { $( "#direct_print" ).trigger( "click" ); });
		</script>
	@endif

<br/>
	<button class="btn submitBtn cancel-button btn-primary no-print" onclick="window.close()"  style="clear:both;margin-top:10px;">Go Back!</button></div>
	<button class="btn submitBtn btn-primary no-print" id="direct_print"  onclick="print_now()" style="clear:both;margin-top:10px;">Print</button></div>
	
	
	<script>function goBack() { window.history.back();}
	
	function print_now(){
		 window.print();
		 @if($print == 'printIT')
			setTimeout(function () { window.close(); }, 100);
		 @endif
		//explode();
	}
	
	function explode(){
	 //  	$.post('ajax.php', {'action': 'unset_thank_sess'}, function(data) {
		// 	console.log(data);
		// 	var l_width = screen.availWidth;
		// 	var l_height = screen.availHeight;
		// 	var myWindow1 = window.open("user_booking_screen.php", "Cinema", "width="+l_width+",height="+l_height);
		// });
	}
	setTimeout(explode(), 5000);

</script>
</html>
