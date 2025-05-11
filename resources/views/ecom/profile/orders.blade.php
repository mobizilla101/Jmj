<x-ecom-home-layout>
    <x-slot name="title">
        Profile | Order | List
    </x-slot>

    <div class="grid grid-cols-[auto_1fr] bg-primary-100">
        <x-partials._profile-sidebar />

        <main class="p-5 w-full overflow-x-auto">
            @if(count($orders) > 0)


                <div class="relative w-full overflow-x-auto mb-5">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Order Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Order Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Transportation Cost
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sub Total
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total
                            </th>
                            <th>

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                        <tr class="bg-white border-b border-gray-200">
                            @php
                            $style = match($order->orderStatus){
                                \App\Enum\OrderStatus::PROCESSING => "bg-yellow-200 border border-yellow-600 text-yellow-900",
                                \App\Enum\OrderStatus::COMPLETED => "bg-green-200 border border-green-600 text-green-900",
                                default => "bg-red-200 border border-red-600 text-red-900"
                            }

                            @endphp
                            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap ">
                                <a href="{{route('auth.profile.orders.view',$order)}}" class="font-semibold cursor-pointer hover:underline">
                                {{$order->created_at->format('m/d/Y')}}
                                </a>
                            </th>
                            <td class="px-6 py-4">
                                <a href="{{route('auth.profile.orders.view',$order)}}" class="cursor-pointer hover:underline">
                                <span class="px-2 py-1 rounded {{$style}}">{{ucfirst($order->orderStatus->value)}}</span>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{route('auth.profile.orders.view',$order)}}" class="cursor-pointer hover:underline">
                                Rs. {{$order->transportation_cost }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{route('auth.profile.orders.view',$order)}}" class="cursor-pointer hover:underline">
                                Rs. {{$order->total}}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{route('auth.profile.orders.view',$order)}}" class="cursor-pointer hover:underline">
                                Rs. {{$order->total + $order->transportation_cost}}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{route('auth.profile.orders.view',$order)}}" class="block flex gap-2 items-center justify-center cursor-pointer hover:underline">
                                    <x-heroicon-o-eye class="w-4 h-4" />
                                    View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{$orders->links()}}


                @else
                <div class="w-full bg-white rounded-2xl p-2 grid place-items-center">
                    <div class="">
                    <div class="p-4 bg-red-500 text-white text-center">X</div>
                    <p>There are no orders placed yet</p>
                    </div>
                </div>
            @endif
        </main>
    </div>

</x-ecom-home-layout>

