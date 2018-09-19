

	$(document).ready(function(){
		var count = 0;
		$(".form-container").on('click', '.make_clone', function() {
			$('.delete_clone').attr('disabled', false);
			count++;
			var html = `
				<div class="col-md-12 clone_div" id="`+count+`">
					<button type="button" style="padding: 4px 10px;background-color: #8D5963;" class="btn submitBtn save-button make_clone" class="btn submitBtn save-button " value="">Copy Schedule</button>
					<button type="button" style="padding: 4px 10px;background-color: #8D5963;" class="btn submitBtn save-button  delete_clone" class="btn submitBtn save-button " value="">Delete</button>
					<div class="col-md-12 inner_clone_div_parent" style="padding:0px;">
						<div class="col-md-6 date_label" style="margin-right: -110px;padding-top: 10px;border-top: 1px solid #ccc;padding-top: 10px;">
							<label for="datetime" class="col-sm-3 control-label"><span>* </span>Show Date</label>
							<div class="col-sm-8">
								<input type="text" name="show_day[`+count+`][day]"  class="show_day form-control" placeholder="Insert date time" required>
							</div>
						</div>
						<div class="col-md-2">	
							<button type="button" style="margin-top:10px;padding: 5px 9px;" class="btn submitBtn save-button clone_time" value="">Add timings</button>
						</div>
					</div>
					<div class="col-md-6">
						<div id="time_confilict" class="time_confilict alert alert-danger" role="alert" style="display:none;padding: 10px;margin-bottom: 5px;"> Date Time can confilict! 
						</div>
					</div>
				</div>
			`;
			var htmlStr = $(this).parent(".clone_div");
			$(htmlStr).clone().attr('id', count).appendTo('.clone_div_parent');
			//$(this).parent().parent('.clone_div_parent').append(html);

			$('#'+count+' .time').each(function () {
				$(this).attr('name','show_day['+count+'][time][]');
			});
		
			$('#'+count+' .show_day').each(function () {
				$(this).attr('name','show_day['+count+'][day]');
				$(this).val("");
			});
		});

		$(".form-container").on('click', '.clone_time', function() {
			var id = $(this).parent().parent().parent('.clone_div').attr("id");
			var text = `
			<div class="col-md-12 row-el" style="border-bottom:0px;margin-bottom:0px;">
				<div class="col-md-6 form-group date_label">
					<label for="showtime_datetime" class="col-sm-3 control-label"><span>* </span> Timings: </label>
					<div class="col-sm-8 show" style="position:relative;">
						<input type="text" name="show_day[`+id+`][time][]" id="showtime_datetime" value="" autocomplete="off" class="time date_p form-control" placeholder="Time" style="width:100px;margin-left: 4px;" required>
						<button type="button" class="btn submitBtn minus-btn" value="" >-</button>
					</div>
				</div>
			</div>
			`;
			$(this).parent().parent('.inner_clone_div_parent').append(text);
			// console.log ( $(this).parent().parent('.inner_clone_div_parent').find('.show_day').attr('name') );
			// console.log ( $(this).parent().parent('.inner_clone_div_parent').find('.time').attr('name') );
		});


		$(".form-container").on('click', '.minus-btn', function() {
            $(this).parent().parent().parent('.row-el').remove();
        });


        $(".form-container").on('click', '.delete_clone', function() {
        	if($('.clone_div').length == 2){
        		$('.delete_clone').attr('disabled', true);
        	}
        	count--;
        	//console.log(count);
            $(this).parent('.clone_div').remove();
        });
	});


	$(".form-container").on('click', '.date_p', function(event) {
		$('.date_p').datetimepicker({
			datepicker:false,
			format:'H:i',
			});
		$('.date_p').datetimepicker({step:10});
	});
			
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
			
			
	$(".form-container").on('focusout', '.show_day', function(event) {
		var textValues = new Array();
		$("input.show_day").each(function() {
			doesExisit = ($.inArray($(this).val(), textValues) == -1) ? false : true;
			if (!doesExisit) {
				textValues.push($(this).val());
				$('#add_showtime').prop('disabled', false);
				$('.make_clone').prop('disabled', false);
				$(this).parent().parent().parent().parent().find('#time_confilict').hide();
			} else {
				$(this).parent().parent().parent().parent().find('#time_confilict').show();
				$('#add_showtime').prop('disabled', true);
				$('.make_clone').prop('disabled', true);	
			}
		});
	});
	
	
	$(".form-container").on('focusout', '.time ', function(event) {
		var textValues = new Array();
		var its_parent = $(this).parent().parent().parent().parent().parent().attr('id');
		$( "#"+its_parent+ " input.time").each(function() {		
			doesExisit = ($.inArray($(this).val(), textValues) == -1) ? false : true;
			if (!doesExisit) {
				textValues.push($(this).val());
				$('#add_showtime').prop('disabled', false);
				$('.make_clone').prop('disabled', false);
				$(this).parent().parent().parent().parent().parent().find('#time_confilict').hide();				
			} else {
				$(this).parent().parent().parent().parent().parent().find('#time_confilict').show();
				$('#add_showtime').prop('disabled', true);
				$('.make_clone').prop('disabled', true);					
			}
		});
	});
			
