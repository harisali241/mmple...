<!DOCTYPE html>
<html>
<head>
	<title>mmplexbh</title>
	
	<style type="text/css">
		td{
			text-align:center;background-color:white;font-weight:bold;color:black;border-bottom: solid 1px #3a4a63;
		}
		table{
			width:90%;border:solid 1px #3a4a63;margin-left:5%;clear:both;box-shadow:0px 0px 3px 1px gray;
		}
		th{
			background-color:#3a4a63;color: white;border:solid 1px #3a4a63; font-weight: bolder;padding-top:10px;padding-bottom: 10px;
		}
	</style>

</head>
<body>

				
<div style="margin:0 auto; width:90%;padding:5%;clear:both;">

	<div style="box-shadow:0px 0px 5px 2px #3a4a63; background-color:#c2d0e8;padding-bottom: 20px;">
		<div style="float:left;background-color:#3a4a63;padding:2%;width:96%;margin-bottom:40px;box-shadow:0px 0px 5px 2px #3a4a63;">
			<div style="width:40%;float: left;">
				<img src="https://megamultiplex.com.pk/assets/logo1.png">
			</div>
			<div style="width:60%;float:right;color: white;font-weight: bolder; font-size: 25px;position:relative;top:30px;">
				<h2>Canceled Ticket</h2>
			</div>
		</div>

		<table border="0" cellspacing="0px">
			<thead>
				<tr>
					<th>User:</th>
					<th>Seat No:</th>
					<th>Movie: </th>
					<th>Screen:</th>
					<th>ShowTime:</th>
				</tr>
			</thead>
			<tbody class="searchable">
				@foreach($cancelTickets as $cancelTicket)
				<tr bgcolor="white" style="border-bottom:solid 2px gray;height:30px;">
					<td align="center">{{Auth::user()->firstName}}</td>
					<td align="center">{{$cancelTicket->seatNumber}}</td>
					<td align="center">{{$cancelTicket->show_times->movies->title}}</td>
					<td align="center"> {{$cancelTicket->show_times->screens->name}}</td>
					<td align="center">{{date('Y-M-d D', strtotime($cancelTicket->show_times->dateTime))}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

</body>
</html>
