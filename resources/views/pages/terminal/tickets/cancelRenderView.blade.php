@foreach($tickets as $ticket)
<tr class="removeMe{{$ticket->id}}">
	<td align="center" valign="center" class="idFromhere"><input type="checkbox" name="allCancel[]" class="allCancel" value="{{$ticket->id}}"></td>
    <td align="center">{{$ticket->id}}</td>
    <td align="center">{{$ticket->movies->title}}</td>
    <td align="center">{{$ticket->screens->name}}</td>
    <td align="center">{{ date('d-M-Y h:i' ,strtotime($ticket->showTime) )}}</td>
    <td style="text-transform:uppercase;" align="center">{{$ticket->seatNumber}}</td>
    <td align="center">{{ date('d-M-Y h:i' ,strtotime($ticket->created_at))}}</td>
    <td class="alignCenter">
        <form action="" method="post" id="delete{{$ticket->id}}">
            <textarea class="remarks"></textarea><br/><br/>
            <input type="hidden" class="id_to_delete" value="{{$ticket->id}}">
            <a style="cursor:pointer;" type="button" class="edit_btn img_delete" data-toggle="modal" data-target=".delete_confirm_modal" >Cancel</a>
        </form>
	</td>
</tr>
@endforeach