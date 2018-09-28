@php $count = 0; @endphp
@foreach($topSellers as $top)
	<div class="col-md-12 col-sm-12 top-sell-row  nopadding">
		<div class="col-md-4 col-sm-4 top-sell-data">{{ $top['name'] }}</div>
		<div class="col-md-4 col-sm-4 top-sell-data">{{ $top['qty'] }}</div>
		<div class="col-md-4 col-sm-4 top-sell-data">{{ $top['price'] }}</div>
	</div>
	@php $count++; @endphp
	@if($count == 10) @php break; @endphp @endif
@endforeach