@component('mail::message')
<h2>{{$contact['message']}}</h2>

<table>
<thead>
<tr>
<td>
Ordered on: <h3>{{Carbon\Carbon::parse($order->created_at)->format('m/d/Y g:i A')}}</h3>
</td>
</tr>
<tr>
<th>Name</th>
<th>Qyt</th>
<th>Price</th>
</tr>
</thead>
<tbody>
@foreach($order->orderedItems as $item)
<tr>
<td>{{$item->item->item}}</td>
<td>{{$item->quantity}} </td>
<td>${{$item->item->price}}</td>
</tr>
@endforeach
@foreach($order->orderedCakes as $cake)
<tr>
<td>{{$cake->cakeItem->item}} (cake)</td>
<td>{{$cake->quantity}} </td>
<td>${{$cake->cakeItem->price}}</td>
</tr>
@endforeach

</tbody>

<tfoot>
<tr>
<td colspan="1">&nbsp;</td>
<th>Total(w/tax)</th>
<th>${{$order->total}}</th>
</tr>

</tfoot>

</table>
<textarea style="width: 100%" class="past-notes" disabled>{{$order->notes}}</textarea>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
