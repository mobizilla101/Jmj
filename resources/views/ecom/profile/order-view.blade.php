<x-ecom-home-layout>
    <x-slot name="title">
        Profile | Orders Details
    </x-slot>

    <div class="grid grid-cols-[auto_1fr] bg-primary-100">
        <x-partials._profile-sidebar />

        <main class="p-5 max-w-[100%] overflow-x-auto">
            @php
                $style = match($order->orderStatus){
                    \App\Enum\OrderStatus::PROCESSING => "bg-yellow-200 border border-yellow-600 text-yellow-900",
                    \App\Enum\OrderStatus::COMPLETED => "bg-green-200 border border-green-600 text-green-900",
                    default => "bg-red-200 border border-red-600 text-red-900"
                };
                $payment_style = match($payment->status){
                    \App\Enum\PaymentStatus::PROCESSING => "bg-yellow-200 border border-yellow-600 text-yellow-900",
                    \App\Enum\PaymentStatus::PENDING => "bg-yellow-200 border border-yellow-600 text-yellow-900",
                    \App\Enum\PaymentStatus::COMPLETED => "bg-green-200 border border-green-600 text-green-900",
                    default => "bg-red-200 border border-red-600 text-red-900"
                };
            @endphp
            <section class="bg-white p-2 space-y-2 sm:space-y-0 sm:grid gap-4 sm:grid-cols-2 mb-4">
                <header class="text-3xl font-bold text-center underline text-blue-400 sm:col-span-2 mb-4">Order Information</header>
                <h2 class="col-span-2 font-semibold"><span class="font-semibold text-xl underline mb-3">Order ID:</span><br />
                    {{$order->id}}</h2>
                <section>
                    <header class="font-semibold text-xl underline mb-3">
                        Order Date
                    </header>
                    <p class="font-semibold hover:underline">
                    {{$order->created_at->format('m/d/Y')}}
                    </p>
                </section>
                <section>
                    <header class="font-semibold text-xl underline mb-3">
                        Sub Total
                    </header>
                    <p class="font-semibold hover:underline">
                    {{$order->total}}
                    </p>
                </section>
                <section>
                    <header class="font-semibold text-xl underline mb-3">
                        Transportation Cost
                    </header>
                    <p class="font-semibold hover:underline">
                    {{$order->transportation_cost}}
                    </p>
                </section>
                <section>
                    <header class="font-semibold text-xl underline mb-3">
                        Status
                    </header>
                    <p class="font-semibold hover:underline">
                        <span class="px-2 py-1 rounded {{$style}}">{{ucfirst($order->orderStatus->value)}}</span>
                    </p>
                </section>
                <section>
                    <header class="font-semibold text-xl underline mb-3">
                        Address
                    </header>
                    <p class="font-semibold hover:underline">
                    {{$order->address}}
                    </p>
                </section>
                <section>
                    <header class="font-semibold text-xl underline mb-3">
                        Contact Number
                    </header>
                    <p class="font-semibold hover:underline">
                        {{$order->phone}}
                    </p>
                </section>
            </section>
            <section class="bg-white rounded py-2 mb-4 overflow-auto w-full max-w-full">
                <header class="text-3xl font-bold text-center underline text-blue-400 sm:col-span-2 mb-4">Ordered Items</header>
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr class="border-t border-b border-blue-400 text-center">
                            <th scope="col" class="px-6 py-3">
                                Image
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Item Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Item Quantity
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Item Price
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total
                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order_items as $order_item)
{{--                            @dd($order_item)--}}
                            <tr class="text-center {{$loop->last?"":"border-b border-b-blue-400"}}">
                                <th scope="col"><img src="{{$order_item['img']}}" alt="{{$order_item['model_no']}} Image" class="w-24 h-24 mx-auto"/></th>
                                <td class="p-3">{{$order_item['model_no']}}</td>
                                <td class="p-3">{{$order_item['quantity']}}</td>
                                <td class="p-3">{{$order_item['amount']}}</td>
                                <td class="p-3">{{$order_item['quantity'] * $order_item['amount']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            @if($payment)
            <section class="bg-white rounded py-2 overflow-auto w-full max-w-full">
                <header class="text-3xl font-bold text-center underline text-blue-400 sm:col-span-2 mb-4">Payment Status</header>
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr class="border-t border-b border-blue-400 text-center">
                            <th scope="col" class="px-6 py-3">
                                Payment Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Payment Type
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Amount
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            {{--                            @dd($order_item)--}}
                            <tr class="text-center">
                                <th scope="col">{{$payment->updated_at->format('m/d/Y')}}</th>
                                <td class="p-3">{{$payment->provider_name}}</td>
                                <td class="p-3"><span class="px-2 py-1 rounded {{$payment_style}}">{{ucfirst($payment->status->value)}}</span></td>
                                <td class="p-3">{{$payment['amount']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            @endif
        </main>
    </div>

</x-ecom-home-layout>

