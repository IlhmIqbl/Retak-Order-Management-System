<x-guest-layout>
    <div class="min-h-screen flex">
        
        <div class="hidden lg:flex w-1/2 bg-black flex-col justify-center items-center text-white relative">
            <div class="z-10 text-center">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Retak Logo" class="w-64 h-auto mx-auto mb-4">
                
                <div class="mt-12 text-gray-500 text-xs tracking-widest uppercase">
                    Design Kami Lagi Style
                </div>
            </div>
            
            <div class="absolute inset-0 bg-repeat opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-white p-12">
            <div class="w-full max-w-md">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Create Account</h2>
                <p class="text-gray-500 mb-8 text-sm">Join Retak Apparel to manage your orders.</p>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <button class="ml-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition duration-200 uppercase tracking-wide text-sm">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>