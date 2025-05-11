<a href="{{ route("auth.google") }}" {{ $attributes->merge(["class"=>"flex justify-center items-center border-2 px-5 py-3 font-semibold shadow bg-white rounded-md hover:ring-2 mb-4"]) }}>
    <img src="{{ asset("assets/images/google-icon.svg") }}" class="w-5 inline-block me-3">
    {{$slot}} with Google
</a>
