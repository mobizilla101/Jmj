<x-profile-layout>
            <section class="rounded-md shadow-xl bg-white px-8 py-6 max-w-2xl mx-auto">
                <h3 class="text-2xl font-bold text-blue-400 mb-4">Change Password</h3>
                @if(session('success'))
                <div class="bg-green-400 bg-opacity-40 border border-green-600 text-green-600 rounded-lg p-4 mb-4 text-center font-medium">
                {{session('success')}}
                </div>
                @endif
                <form method="post" action="{{ route('auth.password.change') }}">
                    @csrf
                    @method('put')

                    <x-form.input type='password' name='current_password' label='Current Password:'/>
                    <x-form.input type='password' name='password' label='New Password:'/>
                    <x-form.input type='password' name='password_confirmation' label='Re-Enter Password:'/>

                    <x-form.button type='submit'>Save Changes</x-form.button>
                </form>
            </section>
</x-profile-layout>
