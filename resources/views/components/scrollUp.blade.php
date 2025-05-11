<button
    x-data="{show: false}"
    x-init="window.addEventListener('scroll',()=>{
        window.pageYOffset > 300? show=true : show=false;
    })"
    x-cloak
    x-bind:class="show? 'opacity-100' : 'opacity-0'"
    x-on:click="window.scrollTo({
        top: 0,
        behavior: 'smooth'
    })"
    class="fixed bottom-[3%] right-[1%] transition-all ease-in-out z-50">
    <x-heroicon-s-arrow-up-circle class="w-16 h-16 text-blue-400"/>
</button>
