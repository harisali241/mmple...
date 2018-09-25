	
	<div class="container top-bar">
		 <div class="row">
			<div class="col-md-6 col-sm-6">
				<a href="{{url('/')}}"><img alt="logo" src="{{ asset('assets/images/logo.png')}}"></a>
			</div><!-- col-md-6 -->
			
			<div class="col-md-6 col-sm-6 right-top-bar">
				<ul class="navbar-right settings">
					<li><a href="#"><p class="user-name">{{ auth::user()->firstName }}<br><span>{{ auth::user()->email }}</span></p></a></li>
					<li>
						<a href="#">
							@if(auth::user()->image == '')

							@else
								<img class="user-img" width="25px" src="{{ asset('assets/images/uploads/m_'.Auth::user()->image) }}"/>
							@endif
						</a>
					</li>
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="setting-icon" src="{{ asset('assets/images/settings.png') }}"/></a>
					  <ul class="dropdown-menu">
					    <li><a href="{{url('/')}}">Admin panel</a></li>
						<li><a href="#" class="logout-btn">Logout</a></li>
						<form action="{{url('logout')}}" method="post" class="logout">
							{{csrf_field()}}
						</form>
					  </ul><!-- dropdown -->
					</li>
				</ul><!-- navbar-right -->
			</div><!-- col-md-6 -->
		 </div><!-- row -->
	</div><!-- container top-bar-->
	
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-4 info_header">
				<a href="#"><p class="">CONCESSIONS<br>
					<span>How your Cinema is doing</span>
				</p></a>
				<img class="down_caret" src="{{ asset('assets/images/down_caret.png') }}">
		            <ul class="dropdown-menu advance_li">
			            @if(in_array('bookConcession',getRoutePath()))<li><a href="{{url('bookConcession')}}">Book Concession</a></li>@endif
					    @if(in_array('cancelConcession',getRoutePath()))<li><a href="{{url('cancelConcession')}}">Cancel Concession</a></li>@endif
					    @if(in_array('voucherConcession',getRoutePath()))<li><a href="{{url('voucherConcession')}}">Voucher Concession</a></li>@endif
					</ul>
			</div><!-- col-md-4 -->
				
			<div class="col-md-4 col-sm-4 info_header">
				<a href="#"><p class="">TICKETS<br>
					<span>({{ date("d-M-y") }})</span>
				</p>
				
				<img class="down_caret" src="{{ asset('assets/images/down_caret.png') }}"></a>
		            <ul class="dropdown-menu advance_li">
			             @if(in_array('booking',getRoutePath()))<li><a href="{{url('booking')}}">Book ticket</a></li>@endif
					     @if(in_array('bookConcession',getRoutePath()))<li><a href="#">Reprint Ticket</a></li>@endif
						 @if(in_array('cancelTicket',getRoutePath()))<li><a href="{{url('cancelTicket')}}">Cancel Ticket</a></li>@endif
						 @if(in_array('cancelLockedSeat',getRoutePath()))<li><a href="{{url('cancelLockedSeat')}}">Cancel Locked Seats</a></li>@endif
				    </ul>
			</div><!-- col-md-4 -->
				
			<div class="col-md-4 col-sm-4 info_header">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		            	<p class="">RESERVE TICKETS<br>
					<span>Best Movie Town</span>
				</p>
						
		            <img class="down_caret" src="{{ asset('assets/images/down_caret.png') }}"></a>
		            <ul class="dropdown-menu advance_li">
			             @if(in_array('advBooking',getRoutePath()))<li><a href="{{url('advBooking')}}">Book Reserve Ticket</a></li>@endif
					     @if(in_array('viewReserve',getRoutePath()))<li><a href="{{url('viewReserve')}}">View Reserve Ticket</a></li>@endif
				    </ul>
			</div><!-- col-md-4 -->
		</div><!-- row -->
	</div><!-- container -->