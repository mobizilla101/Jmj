@component('mail::message')
<h2 style="text-align:center">Order Invoice</h2>

<table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">
<tr>
<td><strong>Order ID:</strong><br>{{ $order->id }}</td>
</tr>
<tr>
<td><strong>Order Date</strong><br>{{ $order->created_at->format('m/d/Y') }}</td>
<td><strong>Sub Total</strong><br>{{ number_format($order->total, 2) }}</td>
</tr>
<tr>
<td><strong>Transportation Cost</strong><br>{{ number_format($order->transportation_cost, 2) }}</td>
<td><strong>Order Status</strong><br>{{ ucfirst($order->orderStatus->value) }}</td>
</tr>
<tr>
<td><strong>Address</strong><br>{{ $order->address }}</td>
<td><strong>Contact Number</strong><br>{{ $order->phone }}</td>
</tr>
</table>


---

## Ordered Items

@component('mail::table')
| Image | Item Name | Quantity | Price | Discount | Total |
|:-----:|:----------|:--------:|:-----:|:--------:|------:|
@foreach($orderDetails as $item)
| ![{{ $item['model_no'] }}]({{ $item['img'] }}) | {{ $item['model_no'] }} | {{ $item['quantity'] }} | {{ $item['amount'] }} | {{ $item['discount']  }}% | {{ number_format($item['quantity'] * ($item['amount'] * (1 - $item['discount'] / 100)), 2) }} |
@endforeach
@endcomponent

@if($order->payment_details)
---

## Payment Information

<table>
<tr style="display: flex;justify-content: space-between;align-items: center;gap: 20px">
<td><strong>Payment Date</strong><br>{{ $order->payment_details->updated_at->format('m/d/Y') }}</td>
<td><strong>Payment Type</strong><br>{{ $order->payment_details->provider_name }}</td>
<td><strong>Payment Status</strong><br>{{ ucfirst($order->payment_details->status->value) }}</td>
<td><strong>Amount</strong><br>{{ number_format($order->payment_details->amount, 2) }}</td>
</tr>
</table>
@endif

---

Thanks for shopping with us!
{{ config('app.name') }}
@endcomponent
