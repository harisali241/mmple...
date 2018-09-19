
<style>
  @media print { .no-print { display: none; }
</style>


<table class="slip" style="width:250px;border:1px solid black;margin:auto;text-align:left;font-size:13px;font-family:helvetica;">
<tr><th colspan="2" style="text-align: center;">Mega Multiplex</th></tr>
<tr><th colspan="2" style="text-align: center;">Millenium Mall Karachi</th></tr>
<tr><th colspan="2" style="text-align: center;"></th></tr>
<tr><th  colspan="2"><hr style="border-top: none; border-bottom:1px dashed #000; height:1px;"/></th></tr>
<tr><th colspan="2" style="text-align: center;">Sales Receipt</th></tr>
<tr><th  colspan="2"><hr style="border-top: none; border-bottom:1px dashed #000; height:1px;"/></th></tr>
<tr><th style="font-size: 11px;font-weight: normal;">Transaction no: </th><th style="font-size: 11px;font-weight: normal;">{{$conD[0]->id}}</th></tr>
<tr><th style="font-size: 11px;font-weight: normal;">Date: {{date("d-m-y")}}</th><th style="font-size: 11px;font-weight: normal;">Time: {{date("h:i a")}}</th></tr>
<tr><th style="font-size: 11px;font-weight: normal;">Cashier: </th><th style="font-size: 11px;font-weight: normal;">{{Auth::user()->name}}</th></tr>
<tr><th  colspan="2"><hr style="border-top: none; border-bottom:1px dashed #000; height:1px;"/></th></tr>
<tr><th>Item</th><th>Price</th></tr>
<tr><th  colspan="2"><hr style="border-top: none; border-bottom:1px dashed #000; height:1px;"/></th></tr>

@foreach($conD as $con)

   @if($con->type == 'item')

      <tr><td>{{$con->items->name}} x {{$con->qty}}</td><td>{{ $con->qty * $con->price }}</td></tr>

   @else

     <tr><th>{{$con->packages->name}} x {{$con->qty}}</th><th>{{ $con->qty * $con->price }}</th></tr>
      @php 
        $pack_items = json_decode($con->packages->itemName);
        $pack_qty = json_decode($con->packages->itemQty);
        $pack_price = json_decode($con->packages->itemPrice);
      @endphp
      @for ($i=0; $i<count($pack_items); $i++)

        <tr><td style="font-size:10px;">{{$pack_items[$i]}} x {{$pack_qty[$i]}}</td><td></td></tr>
        
      @endfor
   

  @endif

@endforeach


  <tr><th  colspan="2"><hr style="border-top: none; border-bottom:1px dashed #000; height:1px;"/></th></tr>
  <tr><th>Net Amount: </th><th>{{$conTotal}}</th></tr>
  <tr><th  colspan="2"><hr style="border-top: none; border-bottom:1px dashed #000; height:1px;"/></th></tr>
  <tr><th style="text-align: center;" colspan="2">Thank you </th></tr>
  <tr><th style="text-align: center;" colspan="2">Millenium Mall Karachi </th></tr>
  <tr><th style="text-align: center;" colspan="2">http://megamultiplex.com.pk</th></tr>

</table>

 

<button class="btn submitBtn btn-primary no-print" id="direct_print"  onclick="print_now()" style="visibility:hidden;clear:both;margin-top:10px;">Print</button></div>

<a href="concession.php"><button class="btn submitBtn cancel-button btn-primary no-print" onclick="window.close()"  style="clear:both;margin-top:10px;">Go Back!</button></a></div>
<button class="btn submitBtn btn-primary no-print" onclick="print_now()"  id="print_it" style="clear:both;margin-top:10px;">Print</button></div>
<script src="{{asset('assets/js/jquery.latest.js')}}"></script>
<script>

    function print_now(){
  		 window.print();
  	}
	
</script>

@if($print != null)
 <script>$( document ).ready(function() { $( "#direct_print" ).trigger( "click" ); });</script>
@endif
