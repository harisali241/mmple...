<div class="container top-bar  no-print">
	 <div class="row">
		<div class="col-md-6 col-sm-6">
			
		</div><!-- col-md-6 -->
		
		<div class="col-md-6 col-sm-6 right-top-bar">
			<ul class="navbar-right settings">
				<li><a href="#"><p class="user-name">{{ Auth::user()->firstName }}<br><span>{{ Auth::user()->email }}</span></p></a></li>
				<li>
					<a href="#">
					@if(Auth::user()->image == '')

					@else
						<img class="user-img" width="25px" src="{{ asset('assets/images/uploads/m_'.Auth::user()->image) }}"/>
					@endif
					</a>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="setting-icon" src="{{ asset('assets/images/settings.png') }}"/></a>
				  <ul class="dropdown-menu">
					
					@if(in_array('screen',getRoutePath()))<li><a href="{{ url('screen') }}">Screens</a></li>@endif
					@if(in_array('moviePerson',getRoutePath()))<li><a href="{{ url('moviePerson') }}">Actors</a></li>@endif
					@if(Auth::user()->id == 1)<li><a href="{{ url('user') }}">Users</a></li>@endif
					@if(in_array('foodCategories',getRoutePath()))<li><a href="{{ url('foodCategories') }}">Food Categories</a></li>@endif
					@if(in_array('timing',getRoutePath()))<li><a href="{{ url('timing') }}">Timings</a></li>@endif
					@if(in_array('logo',getRoutePath()))<li><a href="{{ url('logo') }}">Logo</a></li>@endif
					@if(in_array('slideShow',getRoutePath()))<li><a href="{{ url('slideShow') }}">Slide show</a></li>@endif
					@if(in_array('setting',getRoutePath()))<li><a href="{{ url('setting') }}">Settings</a></li>@endif
					@if(in_array('terminal',getRoutePath()))<li><a href="{{url('terminal')}}">Terminal</a></li>@endif
					{{-- <li><a href="view_expense.php">Expense</a></li>
					<li><a href="view_payroll.php">Payroll</a></li> --}}
					<li><a href="#.">Profit & loss</a></li>
					<li><a href="#." class="logout-btn">Logout</a></li>
					<form action="{{url('logout')}}" method="post" class="logout">
						{{csrf_field()}}
					</form>

				  </ul><!-- dropdown -->
				</li>
			</ul><!-- navbar-right -->
		</div><!-- col-md-6 -->
	 </div><!-- row -->
    </div><!-- container top-bar-->
	
  <div class="container  no-print">
	<div class="row">
	  <div class="col-md-2 menu-logo">
	  	<a href="{{url('/')}}"><img alt="logo" src="{{ asset('assets/images/logo.png') }}"></a>
	  </div> <!-- col-md-2 -->

	 <div class="col-md-10 nopadding">
	 <nav class="dashboard-menu navbar navbar-default">
	    <div class="container-fluid nopadding">
	      <!-- Brand and toggle get grouped for better mobile display -->
	      <div class="navbar-header">
	        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
	          <span class="sr-only">Toggle navigation</span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	        </button>
	      </div>

	     
	    <!-- Collect the nav links, forms, and other content for toggling -->
	      <div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-1" aria-expanded="true">
	        <ul class="nav navbar-nav">	
			 <li class="dashboard-li dropdown">
			 
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	            	Movie
	            	<span class="desc">Your guide to setting</span>
					<span class="desc">up Imagiacian</span>
					<img class="down_caret" src="{{ asset('assets/images/down_caret.png') }}"></a>
	            	<ul class="dropdown-menu">
					    @if(in_array('movie',getRoutePath()))<li><a href="{{ url('movie') }}">Films</a></li>@endif
					    @if(in_array('distributer',getRoutePath()))<li><a href="{{ url('distributer') }}">Distributers</a></li> @endif
					    @if(in_array('showTime',getRoutePath()))<li><a href="{{ url('showTime') }}">Scheduling</a></li> @endif
		     		</ul>
	          </li>
			  

	          <li class="dashboard-li">
	           	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	            	Ticket
	          	<span class="desc">Your guide to setting</span>
				<span class="desc">up Imagiacian</span>
				<img class="down_caret" src="{{ asset('assets/images/down_caret.png') }}"></a>
				<ul class="dropdown-menu">
				     @if(in_array('ticket',getRoutePath()))<li><a href="{{ url('ticket') }}">Ticket Types</a></li>@endif
				    <li><a href="{{ url('deal') }}">Deals</a></li>
		     	</ul>
	          </li>

	            <li class="dashboard-li  dropdown">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		            Concessions 
		            <span class="desc">Your guide to setting</span>
					<span class="desc">up Imagiacian</span>
		            <img class="down_caret" src="{{ asset('assets/images/down_caret.png') }}"></a>
		            <ul class="dropdown-menu">
		              @if(in_array('item',getRoutePath()))<li><a href="{{ url('item') }}">Items</a></li>@endif
		   			  @if(in_array('package',getRoutePath()))<li><a href="{{ url('package') }}">Packages</a></li>@endif
		   			  @if(in_array('foodStall',getRoutePath()))<li><a href="{{ url('foodStall') }}">Food stalls</a></li>@endif
		            </ul>
	          	</li>
	          
	          <li class=" dashboard-li  dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	           	 Corporate sales
	            <span class="desc">Your guide to setting</span>
				<span class="desc">up Imagiacian</span>
	            <img class="down_caret" src="{{ asset('assets/images/down_caret.png') }}"></a>
	            <ul class="dropdown-menu">
	             @if(in_array('voucher',getRoutePath()))<li><a href="{{ url('voucher') }}">Vouchers</a></li>@endif
	             @if(in_array('privateShowTime',getRoutePath()))<li><a href="{{ url('privateShowTime') }}">Show Timings</a></li>@endif
	    		 @if(in_array('privateShowTime/create',getRoutePath()))<li><a href="{{ url('privateShowTime/create') }}">Theaters schedule</a></li>@endif
	            </ul>
	          </li>

	          <li class="dashboard-li dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	            	Report 
					<span class="desc">Your guide to setting</span>
					<span class="desc">up Imagiacian</span>
	            <img class="down_caret" src="{{ asset('assets/images/down_caret.png') }}"></a>
			   <ul class="dropdown-menu">
	            <li><a href="{{ url('movieReport') }}">Movie</a></li>
			    <li><a href="{{ url('concessionReport') }}">Concession</a></li>
			    <li><a href="{{ url('customReport') }}">Custom reports</a></li>
			    </ul>
	          </li>	           
	        </ul>
	      </div><!-- /.navbar-collapse -->
	    </div><!-- /.container-fluid -->
	  </nav>
	  </div><!-- col-md-10 -->
	</div><!-- row -->
  </div><!-- container -->
	 
   <!--/header-->