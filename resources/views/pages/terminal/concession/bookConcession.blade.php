@extends('layouts.t_master')
@section('content')

<div class="container main-container">
	
	<div class="clear"></div>
	<div class="row">
		<div class="col-md-6 nopadding">
			<div id="f_item_height">
				@foreach($items as $item)
					<div class="col-md-6 col-sm-6 drink f_item" style="background-color:{{$item->bgColor}};">
					<div class="col-md-4 icon">
					<img class="img-responsive" src="{{ asset('assets/images/uploads/'.$item->image)}}"/>
					</div>
					<div class="col-md-8 nopadding">
					<p class="drink-size">{{ $item->name }}</p>
					<p class="drink-volume">{{ $item->description }}</p>
					<p class="drink-price">Rs. {{ $item->defaultPrice }}</p>
					</div>
					<input type="hidden" value="{{ $item->id }}" class="single_item_id">
					<input type="hidden" value="{{ $item->name }}" class="single_item_name">
					<input type="hidden" value="{{ $item->description }}" class="single_item_desc">
					<input type="hidden" value="{{ $item->defaultPrice }}" class="single_item_price">
					</div>
				@endforeach
			</div><!-- f_item_height -->
			
			<div class="clear"></div>
					
			<div class="row">
			  	<div class=" col-md-12 col-sm-12 latest-deals">
					<div class="col-md-6 col-sm-6 col-xs-6 nopadding">
						<p>Our Latest Combos & Deals</p>
						<span>Select your combo deals</span>
					</div><!-- col-md-6-->
					
					<div class="col-md-6 col-sm-6 col-xs-6 nopadding">	
						<div class="navbar-right dropdown settings ">
						  <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="setting-icon" src="{{asset('assets/images/settings2.png') }}"/></a>
						  <ul class="dropdown-menu">
							<li><a href="#">HTML</a></li>
							<li><a href="#">CSS</a></li>
							<li><a href="#">JavaScript</a></li>
						  </ul>
						</div>
					</div><!-- col-md-6-->
				</div><!-- latest-deals-->
			</div><!-- row-->
					
			<div class="row">
				<div class="combo_scroll">
					@foreach($packages as $pack)
						@php
							// $item_name = $pack->itemName;
							// $item_name = (!empty($item_name))? json_decode($item_name) : [];

							// $item_qty = $pack->itemQty;
							// $item_qty = (!empty($item_qty))? json_decode($item_qty) : [];
							// $counter = 0;
							$itemName = json_decode($pack->itemName);
							$itemPrice = json_decode($pack->itemPrice);
							$itemQty = json_decode($pack->itemQty);
						@endphp
						<div class="d_item col-md-4 col-sm-4" >
							<div class="deal-desc" style="background-color:{{$pack->bgColor}};">
								<div class="deal-img">
									<img class="img-packponsive" src="{{asset('assets/images/uploads/'.$pack->image)}}"/>
								</div>
								<div class="deal-name">
									<p>{{$pack->name}} <span>({{$pack->description}})</span></p>
								</div>
								<div class="deal-price">
									<p>Rs. {{$pack->defaultPrice}}</p>
								</div>
							</div>
							@for($i=0; $i<count($itemName); $i++)
								<input type="hidden" name="p_item_name[]" class="p_item_name" value="{{$itemName[$i]}}">
								<input type="hidden" name="p_item_price[]" class="p_item_price" value="{{$itemPrice[$i]}}">
								<input type="hidden" name="p_item_qty[]" class="p_item_qty" value="{{$itemQty[$i]}}">
							@endfor
							<input type="hidden" class="single_item_desc" value="{{$pack->description}}">
							<input type="hidden" class="single_item_id" value="{{$pack->id}}">
							<input type="hidden" class="single_item_name" value="{{$pack->name}}">
							<input type="hidden" class="single_item_price" value="{{$pack->defaultPrice}}">
						</div>
					@endforeach
				</div><!-- scroll -->
			</div><!-- row -->
		</div><!-- col-md-7-->
				
		<div class="col-md-6 padding5">
			<div class="deal-bg" >
				<div class="col-md-12 col-sm-12 add-deals-head">
				 <div class="col-md-6 col-sm-6 col-xs-6 nopadding">	
					<p>Add your deals and combos (on particular basis)</p>
					</div><!-- col-md-6-->
					<div class="col-md-6 col-sm-6 col-xs-6 nopadding">	
					<div class="navbar-right dropdown settings ">
					  <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img  src="{{asset('assets/images/settings.png') }}"/></a>
					  <ul class="dropdown-menu">
						<li><a href="#">HTML</a></li>
						<li><a href="#">CSS</a></li>
						<li><a href="#">JavaScript</a></li>
					  </ul>
					</div>
				</div><!-- col-md-6-->
					
				</div><!-- add-deals-head-->
				
				<div class="add-deals-desc">
					<div class="col-md-6 col-sm-6">
						<p>Description</p>
					</div><!-- col-md-9-->
					
					<div class="col-md-2 col-sm-2">
						<p>Price</p>
					</div><!-- add-deals-value-->

					<div class="col-md-2 col-sm-2">
						<p>Qty</p>
					</div><!-- add-deals-value-->

					<div class="col-md-2 col-sm-2">
						<p>Amount</p>
					</div><!-- add-deals-value-->
				</div><!-- col-md-3-->

				<div class="con_scroll">
					<div id="con_terminal">
					
					</div>
				</div><!-- con_scroll-->

			</div><!-- deal-bg-->
			
			<div class="clear"></div>
				
			<div class="function-bg">
			
				<div class="col-md-3 col-sm-3 function-bg-br">
					<img width="33px" id="all_con_delete" class="img-responsive" style="cursor:pointer;" src="{{asset('assets/images/delete_icon.png') }}"/>
					Reset
				</div>
				
				
				<div class="col-md-3 col-sm-3 function-bg-br">
					
				</div>
				
				<div class="col-md-3 col-sm-3 function-bg-br">
					
				</div>
			
			</div><!-- function-bg-->
			
			<div class="clear"></div>
				
			<div class="total-amount">
				<div class="col-md-5 col-sm-6">
					<p class="total-amount-label">Total Amount:<br/>
					<span>Inc: GST</span></p>
				</div><!-- col-md-5-->
				
				<div class="col-md-7 col-sm-6">
					<p class="total-amount-value">Rs. 0.00<br/>
					
					</p><br/>
					<input type="hidden" id="total-amount-value" value="">
					
				</div><!-- col-md-7-->
			</div><!-- total-amount-->
			
			
			<div class="clear"></div>
				
			<div class="ticket-save">
				<div class="col-md-6 col-sm-6">
					
				</div>
						
				<div class="col-md-6 col-sm-6 save-cancel">
				<button class="btn btn-default save-btn" id="print_concession" type="button" >
						Save & Print
				</button>
				
				<button class="btn btn-default save-btn" id="save_concession" type="button" >
						View & Print
				</button>
				
				</div>
						
						
			</div><!-- ticket-type-btn-->
			
			<div class="calculator">
				<label>Given Amount:</label>
				<input type="number" min="0" class="expression1" placeholder="0.00">

				<button class="calculate">Calculate</button>
				<br/><label>Return Amount:</label>
				<input type="text" min="0" class="expression2" placeholder="0.00" readonly="">
			</div><!-- calculator-->
		</div><!-- col-md-5-->

	</div><!-- row -->
	<div class="clear"></div>

</div><!-- container -->
	
	<form action="{{ url('/viewAndPrint_c') }}" method="GET" class="send_booking_id" target="_blank">
		<input type="hidden" name="con_order_id" class="con_order_id">
		<input type="hidden" name="printIT" class="reprint">
	</form>

@endsection

@section('scripts')

<script>
	$( document ).ready(function() {
		var diabled_popup = $('.is_popup').val();
		/*if(diabled_popup == 'no'){
		var l_width = screen.availWidth;
		var l_height = screen.availHeight;
		var myWindow1 = window.open("user_concession_screen.php", "Cinema", "width="+l_width+",height="+l_height);
		}*/
		$('#myTabs a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		});

		(function($){
			$(window).load(function(){

				$("#f_item_height").mCustomScrollbar({
					setHeight:300,
					theme:"inset-2-dark"
				});

				$(".combo_scroll").mCustomScrollbar({
					setHeight:350,
					theme:"inset-2-dark"
				});

				$(".con_scroll").mCustomScrollbar({
					setHeight:430,
					theme:"inset-2-dark"
				})
			});		
		})(jQuery);

		var alreadyItem = [];
		var alreadypack = [];
		$(".f_item").click(function(){
			var i_id = $(this).find('.single_item_id').val();
 			var i_name = $(this).find('.single_item_name').val();
			var i_price = $(this).find('.single_item_price').val();
			var i_desc = $(this).find('.single_item_desc').val();
			

			if(alreadyItem.indexOf(i_id) != -1){
				var c_val = $('.i_qty_'+i_id).val();
				$('.i_qty_'+i_id).val(+c_val + +1);
				$('.con_item_qty').trigger('change');
				subtotalcalc ();
				calculate();
			}else{
				alreadyItem.push(i_id);
			
				con_ter_text = 
				`<div class="concession_item add-deals-item">
					<div class="col-md-6 col-sm-6 add-deal-item-value">
						<p>`+i_name+`<span> (`+i_desc+`)</span></p>
					</div>
									
					<div class="col-md-2 col-sm-2 add-deal-item-value">
						<p>`+i_price+` </p>
					</div>

					<div class="col-md-2 col-sm-2 add-deal-item-value">
						<p>X <input type="number" min="1" class="con_item_qty i_qty_`+i_id+`" value="1"></p>
					</div>

					<div class="col-md-2 col-sm-2 add-deal-item-value">
						<p>
						<img class="img-responsive item_delete" src="{{asset('assets/images/delete_icon.png') }}" style="width:12px;float: right;cursor:pointer;">
						<span class="price_show">`+i_price+`</span>
						</p>
					</div>
					<input type="hidden" class="con_item_id" value="`+i_id+`">
					<input type="hidden" class="con_item_price" value="`+i_price+`">
					<input type="hidden" class="con_item_total" value="`+i_price+`">
					<input type="hidden" class="con_type" value="item">
				</div>`
			  	$(con_ter_text).appendTo('#con_terminal').find('.concession_item');
			  	subtotalcalc ();
			  	if($('.expression1').val() != 0 || $('.expression1').val() !=""){
			  	calculate();
			  	}
			}
 		}); //final_booking

		$(".d_item").click(function(){
			//get package details
			var i_id = $(this).find('.single_item_id').val();
			var i_name = $(this).find('.single_item_name').val();
			var i_price = $(this).find('.single_item_price').val();
			var i_desc = $(this).find('.single_item_desc').val();

			if(alreadypack.indexOf(i_id) != -1){
				var c_val = $('.p_qty_'+i_id).val();
				$('.p_qty_'+i_id).val(+c_val + +1);
				$('.con_item_qty').trigger('change');
				subtotalcalc ();
				calculate();
			}else{
				alreadypack.push(i_id);
				//get package item details
				var p_i_name = [];
					$.each($(this).find('.p_item_name'), function(){  
				       	p_i_name.push($(this).val());
				    });
						
				var p_i_price = [];
					$.each($(this).find('.p_item_price'), function(){  
			         	p_i_price.push($(this).val());
			      	});

				var p_i_qty = [];
					$.each($(this).find('.p_item_qty'), function(){  
			          	p_i_qty.push($(this).val());
			     	});

				con_ter_text = '<div class="concession_item add-deals-item">';
				con_ter_text += '<div class="col-md-6 col-sm-6 add-deal-item-value">';
				con_ter_text += '<p>'+i_name+'<span> ('+i_desc+')</span></p>';
				con_ter_text += '<div class="package_item">';
				for (var i =0; i < p_i_name.length ; i++){
					con_ter_text += '<p style="font-weight:normal;font-size: 12px;">'+p_i_name[i]+': ' +p_i_price[i]+' X '+p_i_qty[i]+' = '+p_i_price[i]*p_i_qty[i] +'</p>';
				}
				con_ter_text += '</div>';
				con_ter_text += '</div>';
								
				con_ter_text += '<div class="col-md-2 col-sm-2 add-deal-item-value">';
				con_ter_text += '<p>'+i_price+' </p>';
				con_ter_text += '</div>';

				con_ter_text += '<div class="col-md-2 col-sm-2 add-deal-item-value">';
				con_ter_text += '<p>X <input type="number" min="1" class="con_item_qty p_qty_'+i_id+'" value="1"></p>';
				con_ter_text += '</div>';

				con_ter_text += '<div class="col-md-2 col-sm-2 add-deal-item-value">';
				con_ter_text += '<p><img class="img-responsive item_delete" src="{{asset('assets/images/delete_icon.png') }}" style="width:12px;float: right;cursor:pointer;"><span class="price_show">'+i_price+'</span></p>';
				con_ter_text += '</div>';
				
				con_ter_text += '<input type="hidden" class="con_item_price" value="'+i_price+'">';
				con_ter_text += '<input type="hidden" class="con_item_total" value="'+i_price+'">';
				con_ter_text += '<input type="hidden" class="con_item_id" value="'+i_id+'">';
				con_ter_text += '<input type="hidden" class="con_type" value="package">';
				con_ter_text += '</div>';
				
				
				$(con_ter_text).appendTo('#con_terminal').find('.concession_item');
				subtotalcalc ();
			}
		}); //final_booking
		
		
		$("#con_terminal").on('click', '.item_delete', function() {
			$(this).parents('.add-deal-item-value').parent('.concession_item').remove();
			subtotalcalc ();
		});

		$("#all_con_delete").click(function(){
			alreadyItem = [];
			alreadypack = [];
 			$(".concession_item").each(function() {
 				$(this).remove();
 				subtotalcalc ();
 				
 			});
 		});


 		$("#con_terminal").on('change', '.con_item_qty', function(event) {
 			var This = $(this).parents('.add-deal-item-value').parent('.concession_item');
 			var this_price = This.find('.con_item_price').val();
 			var this_qty = $(this).val();
 			
 			var final_p = (parseFloat(this_price)) * (parseFloat(this_qty));
 			This.find('.price_show').text(final_p);
 			This.find('.con_item_total').val(final_p);
 			subtotalcalc ();
 			if($('.expression1').val() != 0 || $('.expression1').val() !=""){
		  		calculate();
		  	}
 		});	

 		var all_con_id_arr = [];
 		var total_val="";
		var ord_id ="";
 		$("#save_concession").click(function(){
 			if($('.concession_item').length != 0){
 				var total_v = $('#total-amount-value').val();
				var con_id = [];
				var con_type = [];
				var con_price = [];
				var con_qty = [];
				$(".concession_item").each(function() {
		 				con_id.push($(this).find('.con_item_id').val());
						con_type.push($(this).find('.con_type').val());
						con_price.push($(this).find('.con_item_price').val());
						con_qty.push($(this).find('.con_item_qty').val());		
				});
				$.post('/bookCon', {'type_id':con_id, 'type':con_type, 'price':con_price, 'qty':con_qty, 'total_v':total_v, '_token': '{{csrf_token()}}' }, function(data){
					subtotalcalc ();
					$('.expression1').val(0);
					$('.expression2').val(0);	
					$('#all_con_delete').trigger('click');
					$('.con_order_id').val(data);
					$('.reprint').val('');
					$('.send_booking_id').submit();
				});
				var l_width = screen.availWidth;
				var l_height = screen.availHeight;
				/*if(diabled_popup == 'no'){
				var myWindow1 = window.open("user_concession_screen.php", "Cinema", "width="+l_width+",height="+l_height);
				}*/
 			}
 		});
	
		$("#print_concession").click(function(){
			if($('.concession_item').length != 0){
				var total_v = $('#total-amount-value').val();
				var con_id = [];
				var con_type = [];
				var con_price = [];
				var con_qty = [];
				$(".concession_item").each(function() {
		 				con_id.push($(this).find('.con_item_id').val());
						con_type.push($(this).find('.con_type').val());
						con_price.push($(this).find('.con_item_price').val());
						con_qty.push($(this).find('.con_item_qty').val());				
				});
				$.post('/bookCon', {'type_id':con_id, 'type':con_type, 'price':con_price, 'qty':con_qty, 'total_v':total_v, '_token': '{{csrf_token()}}' }, function(data){
					subtotalcalc ();
					$('.expression1').val(0);
					$('.expression2').val(0);	
					$('#all_con_delete').trigger('click');
					$('.con_order_id').val(data);
					$('.reprint').val('reprint');
					$('.send_booking_id').submit();
				});
				
				 
				var l_width = screen.availWidth;
				var l_height = screen.availHeight;
				/*if(diabled_popup == 'no'){
				var myWindow1 = window.open("user_concession_screen.php", "Cinema", "width="+l_width+",height="+l_height);
				}*/
			}
 		});
		
 		function subtotalcalc (event) {
        	//alert('Press Hit Button');
        	// Sub Total All Amount Table and save in subtotal variable
        	var subtotal = 0;
		    $('.con_item_total').each(function() {
		        subtotal += parseFloat($(this).val());
		    });
		    // Display Value to Sub Total Amount
		    $(".total-amount-value").text('Rs.'+parseFloat(subtotal).toFixed(2));
		    $("#total-amount-value").val(parseFloat(subtotal).toFixed(2));
		}

		$(".calculate").click(function(){
			 calculate();
		});

		function calculate (event) {
			if($('.expression1').val() != 0 || $('.expression1').val() !=""){
			 	var returnamount =  $(".expression1").val() - $("#total-amount-value").val();
			 	$(".expression2").val(returnamount);
			}
		}

	});

</script>
	
@endsection
