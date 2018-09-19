

					<div class="col-md-12">
						<div class="form-group">
							<label for="deal_name" class="col-sm-4 control-label"><span>*</span> Deal Name: </label>
							<div class="col-sm-8">
								<input type="text" name="name" id="deal_name" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					
					<div class="col-md-12">
						<div class="form-group">
							<label for="fixed_deal" class="col-sm-4 control-label">Fixed Deal: </label>
							<div class="col-sm-2">
								<input type="radio" name="deal_type" value="fixed_deal" id="fixed_deal" class="" style="width:1.3em;height:1.3em;border:none;" required>
							</div>
							<label for="custom_deal" class="col-sm-4 control-label">Custom Deals: </label>
							<div class="col-sm-2">
								<input type="radio" name="deal_type" value="custom_deal" id="custom_deal" class="" style="width:1.3em;height:1.3em;border:none;" required>
							</div>
						</div>
						<br>
					</div>
					<div class="clear"></div>
					
					<div class="fixed_deal_box" style="display:none">
						<div class="col-md-12">
							<div class="form-group">
								<label for="fixed_deal" class="col-sm-4 control-label">Free Tickets: </label>
								<div class="col-sm-8">
									<select class="form-control freeTicket" name="freeTicket">
										<option value="">none</option>
										<option value="byOneGetOne">By One Get One</option>
										<option value="byTwoGetOne">By Two Get One</option>
										<option value="byFourGetOne">By Four Get One</option>
										<option value="byEightGetTwo">By Eight Get Two</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="clear"></div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="fixed_deal" class="col-sm-4 control-label">Free Concession: </label>
								<div class="col-sm-8">
									<select class="form-control freeConcession" name="freeConcession">
										<option value="">none</option>
										<option value="byOneTicketGetOneItem">By One Ticket Get One Item</option>
										<option value="byTwoTicketGetOneItem">By Two Ticket Get One Item</option>
										<option value="byFourTicketGetOneItem">By Four Ticket Get One Item</option>
									</select>
								</div>
							</div>
						</div>
						<div class="clear"></div>

						<div class="col-md-12 select_item" style="display: none;">
							<div class="form-group">
								<label for="fixed_deal" class="col-sm-4 control-label">item: </label>
								<div class="col-sm-8">
									<select class="form-control item" name="f_item[]">
										@foreach($items as $item)
											<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="clear"></div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="fixed_deal" class="col-sm-4 control-label">Duration: </label>
								<div class="col-sm-8">
									<select class="form-control select-c-Date duration" name="f_duration">
										<option value="">none</option>
										<option value="forOneDayOnly">For One Day Only</option>
										<option value="weekDays">Week Days</option>
										<option value="onWeekend">On Weekend</option>
										<option value="forOneMonth">For One Month</option>
									</select>
								</div>
							</div>
						</div>
						<div class="clear"></div>

						<div class="col-md-12 one_month"  style="display:none;">
							<div class="form-group">
								<label for="fixed_deal" class="col-sm-4 control-label">Select Month: </label>
								<div class="col-sm-8">
									<select class="form-control month" name="month">
										@foreach(months() as $month)
										 <option value="{{$month}}">{{$month}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						
						<div class="col-md-12 one_day" style="display:none;">
							<div class="form-group">
								<label for="oneday" class="col-sm-4 control-label">Select Date: </label>
								<div class="col-sm-8">
									 <input type="text" name="day" class="oneday show_day form-control" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="clear"></div>					
					</div>

					<div class="custom_deal_box" style="display:none;">
						
						<div class="col-md-12">
							<div class="form-group">
								<label for="freeTicket" class="col-sm-4 control-label">Free Ticket: </label>
								<div class="col-sm-4">
									<div class="row">
										<label for="buy" class="col-sm-6 control-label">Buy: </label>
										<input type="number" min="1" name="ticketBuy" class="col-sm-6 form-control ticket_buy" style="width:70px;">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="row">
										<label for="get" class="col-sm-6 control-label">Get: </label>
										<input type="number" min="1" name="ticketGet" class="col-sm-6 form-control ticket_get" style="width:70px;">
									</div>
								</div>

							</div>
						</div>
						<div class="clear"></div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="freeTicket" class="col-sm-4 control-label">Free Concession: </label>
								<div class="col-sm-4">
									<div class="row">
										<label for="buy" class="col-sm-6 control-label">Buy: </label>
										<input type="number" min="1" name="concessionBuy" class="col-sm-6 form-control concession_buy" style="width:70px;">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="row">
										<label for="get" class="col-sm-6 control-label">Get: </label>
										<input type="number" min="1" name="concessionGet" class="col-sm-6 form-control concession_get" style="width:70px;">
									</div>
								</div>
							</div>
						</div>
						<div class="clear"></div>

						<div class="select_item_box">
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="fixed_deal" class="col-sm-4 control-label">Duration: </label>
								<div class="col-sm-8">
									<select class="form-control select-c-Date duration" name="duration">
										<option value="">none</option>
										<option value="forOneDayOnly">For One Day Only</option>
										<option value="weekDays">Week Days</option>
										<option value="onWeekend">On Weekend</option>
										<option value="forOneMonth">For One Month</option>
										<option value="selectCustomDays">Select Custom Days</option>
									</select>
								</div>
							</div>
						</div>
						<div class="clear"></div>

						<div class="col-md-12 one_month"  style="display:none;">
							<div class="form-group">
								<label for="fixed_deal" class="col-sm-4 control-label">Select Month: </label>
								<div class="col-sm-8">
									<select class="form-control month" name="month">
										@foreach(months() as $month)
										 <option value="{{$month}}">{{$month}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						
						<div class="col-md-12 one_day" style="display:none;">
							<div class="form-group">
								<label for="fixed_deal" class="col-sm-4 control-label">Select Date: </label>
								<div class="col-sm-8">
									 <input type="text" name="oneday" class="oneday show_day form-control" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="clear"></div>
						
						<div class="col-md-12 cus_dates"  style="display:none;">
							<div class="form-group">
								<label for="fixed_deal" class="col-sm-4 control-label">Start Date: </label>
								<div class="col-sm-8">
									 <input type="text" name="startDate" id="date_timepicker_start" class="startDate datetimepicker form-control" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="clear"></div>

						<div class="col-md-12 cus_dates"  style="display:none;">
							<div class="form-group">
								<label for="fixed_deal" class="col-sm-4 control-label">Expire Date: </label>
								<div class="col-sm-8">
									 <input type="text" name="endDate" id="date_timepicker_end" class=" endDate form-control datetimepicker" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>



					$(document).ready(function(){

			$('.form-container').on('click', '#fixed_deal', function(){
				$('.fixed_deal_box').fadeIn(500);
				$('.custom_deal_box, .one_day, .one_month, .cus_dates, .select_item, .select_item2').fadeOut(500);
				
				$('.freeTicket').val(''); $('.freeConcession').val(''); $('.duration').val(''); $('.month').val(''); $('.oneday').val(''); $('.startDate').val(''); $('.endDate').val(''); $('.ticket_buy').val(''); $('.ticket_get').val(''); $('.concession_buy').val(''); $('.concession_get').val('');
			});
			$('.form-container').on('click', '#custom_deal', function(){
				$('.custom_deal_box').fadeIn(500);
				$('.fixed_deal_box, .one_day, .one_month, .cus_dates, .select_item, .select_item2').fadeOut(500);
				$('.freeTicket').val(''); $('.freeConcession').val(''); $('.duration').val(''); $('.month').val(''); $('.oneday').val(''); $('.startDate').val(''); $('.endDate').val(''); $('.ticket_buy').val(''); $('.ticket_get').val(''); $('.concession_buy').val(''); $('.concession_get').val('');
			});

			$('.select-c-Date').on('change', function(){
				if($(this).val() == 'selectCustomDays'){
					$('.cus_dates').fadeIn(500);
					$('.one_day, .one_month').fadeOut(500);
				}else if($(this).val() == 'forOneDayOnly'){
					$('.one_day').fadeIn(500);
					$('.cus_dates, .one_month').fadeOut(500);
				}else if($(this).val() == 'forOneMonth'){
					$('.one_month').fadeIn(500);
					$('.cus_dates, .one_day').fadeOut(500);
				}else{
					$('.cus_dates, .one_day, .one_month').fadeOut(500);
				}
			});

			$('.freeConcession').on('change', function(){
				if($(this).val() == 'byFourTicketGetTwoItem'){
					$('.select_item, .select_item2').fadeIn(500);
				}else if($(this).val() == ''){
					$('.select_item, .select_item2').fadeOut(500);
				}else{
					$('.select_item').fadeIn(500); 
					$('.select_item2').fadeOut(500);
				}
			});


			$('.concession_get').on('keyup change', function(){
				html = '';
				html = `
					<div class="col-md-12 select_item">
						<div class="form-group">
							<label for="fixed_deal" class="col-sm-4 control-label">item: </label>
							<div class="col-sm-8">
								<select class="form-control item" name="item[]">
									@foreach($items as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				`;
				var count = $('.concession_get').val();
				var htmls = '';
				for(var i=0; i<count; i++){
					htmls += html;
				}
				$('.select_item_box').html(htmls);
			})

			$(".form-container").on('click', '.show_day', function(event) {
				var dateToday = new Date();
				$('.show_day').datetimepicker({
					format:'Y/m/d',
					timepicker:false,
					dayOfWeekStart : 1,
					lang:'en',
					minDate : dateToday
					});
				$('.show_day').datetimepicker({step:10});
			});
		});