@extends('layouts.master')
@section('content')

	

<div class="container">

	<div class="row">
		<ol class="breadcrumb">
		  <li><a href="{{url('/')}}">Home</a></li>
		  <li><a href="{{url('/user')}}">Users</a></li>
		  <li class="active">Add User</li>
		</ol>
	</div><!--row-->

	<form class="form-horizontal dashboardForm"  action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<div class="row gray-header">
			<div class="col-md-12">
				<div class="form-header-inner">
					<div class="col-sm-6">
						<h3> User Details</h3>
					</div>
			 		<div class="col-sm-6 action_btn">
			 			<button type="button" class="btn submitBtn cancel-button">Cancel</button>
				 		<button type="submit" class="btn submitBtn save-button">Add User</button>
			 		</div>
			 	</div>
		 	</div>
	  	</div><!--row-->

	  	@include('includes.error')
		@include('includes.success')

		<div class="row">
			<div class="form-container">
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="form-group">
							<label for="fname" class="col-sm-4 control-label">First Name: </label>
							
							<div class="col-sm-8">
								<input type="text" class="form-control" name="firstName" id="fname" value="" required>
							</div>
						</div>
					</div>
						

					<div class="col-md-12">
						<div class="form-group">
							<label for="lname" class="col-sm-4 control-label">Last Name: </label>
							
							<div class="col-sm-8">
								<input type="text" class="form-control" name="lastName" id="lname" value="" required>
							</div>
						</div>
					</div>


					<div class="col-md-12">
						<div class="form-group">
							<label for="email" class="col-sm-4 control-label">Email: </label>
							
							<div class="col-sm-8">
								<input type="email" class="form-control" name="email" id="email" value="" required>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="username" class="col-sm-4 control-label">Username: </label>
							
							<div class="col-sm-8">
								<input type="text" class="form-control" name="username" id="username" value="" required>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="username" class="col-sm-4 control-label">Password: </label>
							
							<div class="col-sm-8">
								<input type="password" class="form-control" name="password" id="password" value="" placeholder="" >
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="password" class="col-sm-4 control-label">Mobile: </label>
							
							<div class="col-sm-8">
								<input type="text" class="form-control" name="phoneNo" id="mobile" value="" required>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="city" class="col-sm-4 control-label">City: </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="city" id="city" value="" required>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="city" class="col-sm-4 control-label">Salary: </label>
							
							<div class="col-sm-8">
								<input type="text" class="form-control" name="salary" id="salary" value="" required>
							</div>
						</div>
					</div>

				</div><!-- col-md-6 -->

							

				<div class="col-md-4 col-md-offset-2">
					<div class="col-md-12 item_img">
						<div class="col-md-12 movie-poster">
							<div class="form-group">
								<label for="movie_synopsis" class="col-sm-2 control-label">Image: </label>
								<div class="col-sm-10">
									<input type="file" name="image" class="form-control" style="width:100%;height: 33px;">
								</div>
							</div>
						</div>
					</div>
				</div><!-- col-md-6 -->

				<div class="col-xs-12">
					<div class="form-group">
						<label for="permission" class="col-sm-4 control-label">Permission Allow: </label><br><br>
						<div class="container">
							<div class="row" style="margin-left: 20px;">
								<div class="col-md-12">
									@php $mainMenu = [1, 11, 15, 25, 130]; @endphp
									@for($i=0; $i < count($mainMenu); $i++)
									<div class="iamParent">
										@foreach($menus as $menu)

											@if($menu->id == $mainMenu[$i])
												<div class="parent-1" style="cursor:pointer;">
													<b>{{$menu->name}}</b>
													<input type="checkbox" class="checkParent" value="">
												</div>
											@endif
											
											@if( $menu->type_id == $mainMenu[$i] && $menu->parent_id == null )
												<div class="child-1" data="{{$menu->id}}">
													<label><b>{{$menu->name}}</b></label>
													<input type="checkbox" class="checkChild" value="">
												</div>
											@endif
											
											@if($menu->type_id == $mainMenu[$i] && $menu->parent_id != null)
												<div class="g-child-1 g-child-{{$menu->parent_id}}">
													<div class="checkbox">
													    <label>
													      <input type="checkbox" class="checkboxPer" name="permission[]" value="{{ $menu->id }}">{{ $menu->name }}
													    </label>
													</div>	
												</div>
											@endif
										
										@endforeach
									</div>
									@endfor
								</div>
							</div>

							<div class="row" style="margin-left: 20px;">
								<div class="col-md-12">
									<div class="iamParent">
										@foreach($menus as $menu)

											@if($menu->id == 32)
												<div class="parent-1" style="cursor:pointer;">
													<b>{{$menu->name}}</b>
													<input type="checkbox" class="checkParent" value="">
												</div>
											@endif
											
											@if( $menu->type_id == 32 && $menu->parent_id == null )
												<div class="child-1">
													<div class="checkbox">
													    <label>
													      <input type="checkbox" class="checkboxPer" name="permission[]" value="{{ $menu->id }}">{{ $menu->name }}
													    </label>
													</div>	
												</div>
											@endif
											
											@if($menu->type_id == 32 && $menu->parent_id != null)
												<div class="g-child-1 g-child-{{$menu->parent_id}}">
													<div class="checkbox">
													    <label>
													      <input type="checkbox" class="checkboxPer" name="permission[]" value="{{ $menu->id }}">{{ $menu->name }}
													    </label>
													</div>	
												</div>
											@endif
										
										@endforeach
									</div>
								</div>
							</div>

							<div class="row" style="margin-left: 20px;">
								<div class="col-md-12">
									<div class="iamParent">
										@foreach($menus as $menu)

											@if($menu->id != 126)
												@if($menu->parent_id != 126)
													@if($menu->id == 123)
														<div class="parent-1" style="cursor:pointer;">
															<b>{{$menu->name}}</b>
															<input type="checkbox" class="checkParent" value="">
														</div>
													@endif
													
													@if( $menu->type_id == 123 && $menu->parent_id == null )
														<div class="child-1" data="{{$menu->id}}">
															<label><b>{{$menu->name}}</b></label>
															<input type="checkbox" class="checkChild" value="">
														</div>
													@endif
													
													@if($menu->type_id == 123 && $menu->parent_id != null)
														<div class="g-child-1 g-child-{{$menu->parent_id}}">
															<div class="checkbox">
															    <label>
															      <input type="checkbox" class="checkboxPer" name="permission[]" value="{{ $menu->id }}">{{ $menu->name }}
															    </label>
															</div>	
														</div>
													@endif
												@endif
											@endif

										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- form-container -->

		</div><!-- row -->


	</form>

</div>
<br><br>
@endsection



@section('scripts')


	<script type="text/javascript">

		$(document).ready(function(){

			$('.child-1').hide();
			$('.g-child-1').hide();
			$('.parent-1').on('click', function(e){
				if (e.target !== this)
   				 return;
				if($(this).parent('.iamParent').find('.child-1').is(":visible")){
					$(this).parent('.iamParent').find('.child-1').fadeOut(200);
					$(this).parent('.iamParent').find('.g-child-1').fadeOut(100);
				}else{
					$(this).parent('.iamParent').find('.child-1').fadeIn(200);
				}
			});
			$('.checkParent').on('change', function(){
				if($(this).is(':checked') == true){
					$(this).parent().parent('.iamParent').find('.child-1').find('.checkChild').prop('checked', true);
					$(this).parent().parent('.iamParent').find('.g-child-1').find('.checkboxPer').prop('checked', true);
				}else{
					$(this).parent().parent('.iamParent').find('.child-1').find('.checkChild').prop('checked', false);
					$(this).parent().parent('.iamParent').find('.g-child-1').find('.checkboxPer').prop('checked', false);
				}
			});
			$('.checkChild').on('change', function(){
				var id = $(this).parent('.child-1').attr('data');
				if($(this).is(':checked') == true){
					$(this).parent().parent('.iamParent').find('.g-child-'+id).find('.checkboxPer').prop('checked', true);
				}else{
					$(this).parent().parent('.iamParent').find('.g-child-'+id).find('.checkboxPer').prop('checked', false);
				}
			});
			$('.child-1').on('click', function(e){
				if (e.target !== this)
   				 return;
				var id = $(this).attr('data');
				if($(this).parent('.iamParent').find('.g-child-'+id).is(":visible")){
					$(this).parent('.iamParent').find('.g-child-'+id).fadeOut(200);
				}else{
					$(this).parent('.iamParent').find('.g-child-'+id).fadeIn(200);
				}
			})
		});




		// $('.checkParent').on('change', function(){
		// 	if($(this).is(':checked') == true){
		// 		$(document).ready(function(){
		// 		$('.checkboxv').prop('checked', true);
		// 		});
		// 	}else{
		// 		$(document).ready(function(){
		// 		$('.checkboxv').prop('checked', false);
		// 		});
		// 	}
		// });

		// $('.checkAllc').on('change', function(){
		// 		if($(this).is(':checked') == true){
		// 			$(document).ready(function(){
		// 			$('.checkboxc').prop('checked', true);
		// 			});
		// 		}else{
		// 			$(document).ready(function(){
		// 			$('.checkboxc').prop('checked', false);
		// 			});
		// 		}
		// });

		// $('.checkAlle').on('change', function(){
		// 		if($(this).is(':checked') == true){
		// 			$(document).ready(function(){
		// 			$('.checkboxe').prop('checked', true);
		// 			});
		// 		}else{
		// 			$(document).ready(function(){
		// 			$('.checkboxe').prop('checked', false);
		// 			});
		// 		}
		// });

		// $('.checkAlld').on('change', function(){
		// 		if($(this).is(':checked') == true){
		// 			$(document).ready(function(){
		// 			$('.checkboxd').prop('checked', true);
		// 			});
		// 		}else{
		// 			$(document).ready(function(){
		// 			$('.checkboxd').prop('checked', false);
		// 			});
		// 		}
		// });

		// $('.checkAllr').on('change', function(){
		// 		if($(this).is(':checked') == true){
		// 			$(document).ready(function(){
		// 			$('.checkboxr').prop('checked', true);
		// 			});
		// 		}else{
		// 			$(document).ready(function(){
		// 			$('.checkboxr').prop('checked', false);
		// 			});
		// 		}
		// });
	</script>

@endsection