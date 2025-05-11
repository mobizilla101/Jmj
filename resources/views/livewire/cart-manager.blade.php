<script>
    function initialData() {
        return {
            cartItems: @json($carts),
            subTotal: 0,
            calculate(){

            }
            ,
            updateCartItems(newCart) {
                this.cartItems = newCart;
            },

            removeItem(item_type, id) {
                @this.removeItem(item_type, id).then(newCart => this.updateCartItems(newCart));
            },

            increaseItem(item_type, id) {
                @this.increaseQuantity(item_type, id).then(newCart => this.updateCartItems(newCart));
            },

            decreaseItem(item_type, id) {
                @this.decreaseQuantity(item_type, id).then(newCart => this.updateCartItems(newCart));
            }
        };
    }

</script>

<div class="font-sans max-w-5xl max-md:max-w-xl mx-4 bg-white py-4" x-data="initialData">
    <h1 class="text-3xl font-bold text-gray-800 text-center mb-4">Shopping Cart</h1>
    <div class="grid grid-cols-2 md:grid-cols-[auto_30%] gap-4">

            <div class="col-span-2 md:col-span-1 space-y-4">
                <!-- Loop through cart items dynamically -->
                <template x-for="(item, index) in cartItems" :key="index">
                    <div class="grid grid-cols-3 md:flex gap-4">
                        <div class="flex items-start gap-4">
                            <a :href="item.url" class="block w-28 h-28 max-sm:w-24 max-sm:h-24 shrink-0 p-2 rounded-md"
                                 :style="'background-color:' + (item.color.color_code || '#fffff')">
                                <img :src="item.img" alt="" class="w-full h-full object-contain"/>
                            </a>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-base font-bold text-gray-800"><a :href="item.url" x-text="item.model_no"></a></h3>
                            <p class="text-xs font-semibold text-gray-500 mt-0.5" x-show="item.storage">
                                Storage: <span x-text="item.storage"></span>
                            </p>
                            <p class="text-xs font-semibold text-gray-500 mt-0.5" x-show="item.memory">
                                Ram: <span x-text="item.memory"></span>
                            </p>

                            <button type="button"
                                    class="mt-6 font-semibold text-red-500 text-xs flex items-center gap-1 shrink-0"
                                    x-on:click="removeItem(item.item_type,item.id)">
                                <x-heroicon-o-trash class="w-4 inline"/>
                                REMOVE
                            </button>
                        </div>

                        <div class="ml-auto">
                            <h4 class="text-lg max-sm:text-base font-bold text-gray-800">
                                Rs. <span x-text="Math.floor(item.amount - (item.discount/100))"></span>
                            </h4>

                            <button type="button"
                                    class="mt-6 flex ms-auto items-center border border-gray-300 text-gray-800 text-xs outline-none bg-transparent rounded-md">
                                <x-heroicon-o-minus class="ps-3 py-1.5 w-8 text-black"
                                                    x-on:click="decreaseItem(item.item_type,item.id)"/>
                                <span class="mx-3 font-bold" x-text="item.quantity"></span>
                                <x-heroicon-o-plus class="pe-3 py-1.5 w-8 text-black"
                                                   x-on:click="increaseItem(item.item_type,item.id)"/>
                            </button>
                        </div>
                    </div>
                </template>

                <template x-if="cartItems.length === 0">
                    <div class="bg-gray-100 rounded-md p-4 text-center">
                        There are no items in your cart.
                    </div>
                </template>

        </div>

        <!-- Order Summary -->
        <div class="bg-gray-100 rounded-md p-4 h-max col-span-2 md:col-span-1">
            <h3 class="text-lg max-sm:text-base font-bold text-gray-800 border-b border-gray-300 pb-2">
                Order Summary
            </h3>

            <ul class="text-gray-800 mt-6 space-y-3">
                <li class="flex flex-wrap gap-4 text-sm">Subtotal <span class="ml-auto font-bold">Rs. {{$subTotal}}</span></li>
                <li class="flex flex-wrap gap-4 text-sm pb-12 border-b border-b-gray-600">Shipping <span class="ml-auto font-bold">Rs. {{$transportationCost}}</span></li>
                <li class="flex flex-wrap gap-4 text-sm font-bold">Total <span class="ml-auto">Rs. {{$total}}</span></li>
            </ul>

            <div class="mt-6 space-y-3">
                <a href="{{route('checkout')}}"
                   class="inline-block w-full text-center text-sm px-4 py-2.5 font-semibold tracking-wide bg-gray-800 hover:bg-gray-900 text-white rounded-md"
                   :class="cartItems.length === 0 ? 'opacity-50 pointer-events-none' : ''">
                    Checkout
                </a>
                <a href="{{route('buy')}}"
                   class="inline-block w-full text-center text-sm px-4 py-2.5 font-semibold tracking-wide bg-transparent text-gray-800 border border-gray-300 rounded-md"
                   :class="cartItems.length === 0 ? 'opacity-50 pointer-events-none' : ''">
                    Continue Shopping
                </a>
            </div>
        </div>

    </div>
</div>
