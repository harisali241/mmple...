<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/keyboard.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/jquery-ui.min.css') }}" rel="stylesheet">
	
	
</head>
<body>

	@if($errors->any())
		<div class="col-md-4 col-md-offset-4 paddingTop marginTop" style="margin-top:20px;"><div class="alert alert-danger" role="alert"> Invalid Username / Password </div></div>
	@endif
	<div class="container paddingTop marginTop">

		<div class="col-md-4"></div>
	  	<div class="col-md-4 paddingTop marginTop" style="background: #CECECE;padding: 15px;margin-top:10px;border: 2px solid #337AB7;font-family: monospace;">
		<div class="col-md-12" style="background: #363636;padding: 12px 10px;text-align: center; margin-bottom: 10px; margin-top: 20px;">
			<img src="{{ asset('assets/images/logo.png') }}"/>
		</div>

		  <form class="form-signin" action="{{ route('login') }}" method="post">
		  	{{ csrf_field() }}
		    <h2 class="form-signin-heading" style="text-align: center;font-size: 21px; text-transform: uppercase;font-weight: bold; font-family: monospace;">Please sign in</h2>

		    <label for="username" class="sr-only">Email address</label>
			<p id="username-opener" style="cursor:pointer;font-size: 12px;"><img  style="margin-right:10px;width: 19px;margin-top: -8px;" class="tooltip-tipsy" title="Click to open the virtual keyboard" src="{{ asset('assets/images/uploads/keyboard.svg') }}">Open keyboard</p>
		    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required="" autofocus="" style="margin-bottom: 15px; padding: 5px 12px;height: 40px;background: white;color: black;border: 0;">
		    
			<label for="password" class="sr-only">Password</label>
			<p id="password-opener" style="cursor:pointer;font-size: 12px;"><img  style="margin-right:10px;width: 19px;margin-top: -8px;" class="tooltip-tipsy" title="Click to open the virtual keyboard" src="{{ asset('assets/images/uploads/keyboard.svg') }}">Open keyboard</p>
		    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required=""  style="margin-bottom: 15px; padding: 5px 12px;height: 40px;background: white;color: black;border: 0;">
		    <button class="btn btn-lg btn-primary btn-block" type="submit"  name="login" value="Login">	Login</button>
		  </form>
		</div>
		<div class="col-md-4"></div>
	</div>
	<script src="{{ asset('assets/js/jquery-1.11.1.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.keyboard.js') }}"></script>	
	<!-- keyboard extensions (optional) -->
	<script src="{{ asset('assets/js/jquery.keyboard.extension-typing.js') }}"></script>
	
	<script>
	$('#username').keyboard({
		openOn : null,
		stayOpen : true,
		layout : 'qwerty'
	}).addTyping();

	$('#username-opener').click(function(){
		var kb = $('#username').getkeyboard();
		// close the keyboard if the keyboard is visible and the button is clicked a second time
		if ( kb.isOpen ) {
			kb.close();
		} else {
			kb.reveal();
		}
	});
	
	$('#password').keyboard({
		openOn : null,
		stayOpen : true,
		layout : 'qwerty'
	}).addTyping();

	$('#password-opener').click(function(){
		var kb = $('#password').getkeyboard();
		// close the keyboard if the keyboard is visible and the button is clicked a second time
		if ( kb.isOpen ) {
			kb.close();
		} else {
			kb.reveal();
		}
	});
	</script>
</body>
</html>