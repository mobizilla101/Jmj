<x-ecom-home-layout>

    <main>
<div class="font-[sans-serif] bg-white">
    <div class="flex max-sm:flex-col gap-12 max-lg:gap-4 h-full">
        <div class="bg-gray-100 sm:sticky sm:top-0 lg:min-w-[370px] sm:min-w-[300px]">
            <div class="relative h-full flex flex-col justify-between">
                <div class="px-4 py-8 sm:overflow-auto">
                    <div class="space-y-4">
                        @foreach($cartItems as $cartItem)
                        <div class="flex items-start gap-4">
                            <div class="w-32 h-28 max-lg:w-24 max-lg:h-24 flex p-3 shrink-0 rounded-md" style="background-color:{{$cartItem['color']['color_code'] ?? 'white'}};">
                                <img src='{{$cartItem['img']}}' alt="" class="w-full object-contain" />
                            </div>
                            <div class="w-full">
                                <h3 class="text-sm lg:text-base text-gray-800 font-semibold">{{$cartItem['model_no']}}</h3>
                                <ul class="text-xs text-gray-800 space-y-1 mt-3">
                                    <li class="flex flex-wrap gap-4">Quantity <span class="ml-auto">{{$cartItem['quantity']}}</span></li>
                                    <li class="flex flex-wrap gap-4">Per Price <span class="ml-auto">Rs. {{$cartItem['amount']}}</span></li>
                                    <li class="flex flex-wrap gap-4">Total Price <span class="ml-auto">Rs. {{$cartItem['quantity'] *$cartItem['amount']}}</span></li>
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-200 w-full p-4">
                    <p class="flex flex-wrap gap-4 text-sm lg:text-base font-semibold text-gray-800 mb-2">Sub-Total <span class="ml-auto">Rs. {{$subTotal}}</span></p>
                    <p class="flex flex-wrap gap-4 text-sm lg:text-base font-semibold text-gray-800 mb-2 pb-6 border-b border-b-gray-600">Transportation Cost <span class="ml-auto">Rs. {{$transportationCost}}</span></p>
                    <p class="flex flex-wrap gap-4 text-sm lg:text-base font-semibold text-gray-800">Total <span class="ml-auto">Rs. {{$total}}</span></p>
                </div>
            </div>
        </div>

        <div class="max-w-4xl w-full h-max rounded-md px-4 py-8 sticky top-0">
            <h2 class="text-2xl font-bold text-gray-800">Complete your order</h2>
            <form action="{{route('checkout')}}" method="POST" class="mt-8">
                @csrf
                <div class="mt-8">
                    <h3 class="text-lg lg:text-xl text-gray-800 mb-4">Shipping Information</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="address" class="hidden">Address</label>
                            <input type="text" placeholder="Address"
                                   id="address"
                                   name="address"
                                   value="@if(auth()->user()->address){{auth()->user()->address}}@endif"
                                   class="px-4 py-3 bg-gray-100 focus:bg-transparent text-gray-800 w-full text-sm rounded-md focus:outline-blue-600" />
                            <x-form.error name="address" />
                        </div>
                        <div>
                            <label for="number" class="hidden">Phone number</label>
                            <input type="number" placeholder="Phone No."
                                   name="phone"
                                   value="@if(auth()->user()->phone){{auth()->user()->phone}}@endif"
                                   id="number"
                                   class="px-4 py-3 bg-gray-100 focus:bg-transparent text-gray-800 w-full text-sm rounded-md focus:outline-blue-600" />
                            <x-form.error name="phone" />

                        </div>

                    </div>


                </div>
                <div class="mt-8">
                    <header class="text-lg font-semibold text-gray-800 mb-4">Payment Method</header>
                    <div class="space-y-4">
                        @foreach(array_filter(config('payments'),fn($elem)=>$elem['enabled'] === true) as $payment)
                            <div class="">
                                <label for="payment-{{$payment['key']}}" class="flex items-center gap-4 p-4 border border-gray-200 rounded-md hover:shadow-md transition-shadow cursor-pointer">
                                    <input type="radio" id="payment-{{$payment['key']}}" name="payment_method" value="{{$payment['key']}}" class="h-5 w-5 text-blue-600 focus:ring focus:ring-blue-500">
                                    @if($payment['logo'])
                                        <img src="{{asset('assets/images/'.$payment['logo'])}}" alt="{{$payment['name']}}" class="w-8 h-8 object-contain">
                                    @endif
                                    @if($payment['icon'])
                                            @svg($payment['icon'],'w-6 h-6')
                                    @endif
                                    {{$payment['name']}}
                                </label>

                            </div>
                        @endforeach
                            <x-form.error name="payment_method" />

                    </div>
                </div>

                <div class="flex gap-4 max-md:flex-col mt-8">
                        <a href="{{route('checkout.cancel')}}" class="rounded-md px-4 py-2.5 w-full text-sm tracking-wide bg-transparent hover:bg-gray-100 border border-gray-300 text-gray-800 max-md:order-1">Cancel</a>
                        <button type="submit" class="rounded-md px-4 py-2.5 w-full text-sm tracking-wide bg-blue-600 hover:bg-blue-700 text-white">Complete Purchase</button>
                    </div>
            </form>
        </div>
    </div>
</div>
    </main>
</x-ecom-home-layout>
