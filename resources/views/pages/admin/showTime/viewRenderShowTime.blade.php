@foreach($showTimesPag as $showTime)
	<tr>
		<td>{{ $showTime->movies->title }}</td>
		<td>{{ $showTime->screens->name }}</td>
		<td>{{ date('d-M-Y h:i A', strtotime($showTime->dateTime)) }}</td>
		<td>
			@if($showTime->status == 1)
				<p>active</p>
			@elseif($showTime->status == 0)
				<p>Inactive</p>
			@else
				<p>planned</p>
			@endif
		</td>

		@if(in_array('showTime.edit', getRoutes()))<td class="alignCenter"><a class="edit_btn" href="{{ url('showTime/'.$showTime->id.'/edit') }}">Edit</a></td>@endif
		@if(in_array('showTime.destroy', getRoutes()))
		<td class="alignCenter">
			<form action="{{ url('showTime/'.$showTime->id) }}" method="post" id="delete{{$showTime->id}}">
           		{{ csrf_field() }}
           		{{method_field("DELETE")}}
				<input type="hidden" class="id_to_delete" value="{{ $showTime->id }}"><a style="cursor:pointer;" data-toggle="modal" data-target=".delete_confirm_modal"><img class="img_delete" src="{{ asset('assets/images/delete_icon.png') }}"/></a>
			</form>	
		</td>
		@endif
	</tr>
@endforeach
<div style="text-align: center;margin-bottom:10px;">{{$showTimesPag->links()}}</div>