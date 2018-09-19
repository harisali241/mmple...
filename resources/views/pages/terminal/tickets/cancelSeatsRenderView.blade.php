@foreach($seats as $seat)
<tr class="removeMe{{$seat->id}}">
	<td align="center" valign="center" class="idFromhere"><input type="checkbox" name="allCancel[]" class="allCancel" value="{{$seat->id}}"></td>
    <td align="center" style="text-transform:uppercase;" >{{$seat->seatNumber}}</td>
    <td align="center">{{$seat->show_times->screens->name}}</td>
    <td align="center">{{ date('d-M-Y h:i' ,strtotime($seat->show_times->dateTime))}}</td>
    <td align="center">{{ date('d-M-Y h:i' ,strtotime($seat->created_at))}}</td>
    <td class="alignCenter">
        <form action="" method="post" id="delete{{$seat->id}}">
            <input type="hidden" class="id_to_delete" value="{{$seat->id}}">
            <a style="cursor:pointer;" type="button" class="edit_btn img_delete" data-toggle="modal" data-target=".delete_confirm_modal" >Cancel</a>
        </form>
	</td>
</tr>
@endforeach