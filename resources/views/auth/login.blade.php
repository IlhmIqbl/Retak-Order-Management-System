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
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Order Management System</h2>
                <p class="text-gray-500 mb-8 text-sm">Please log in to manage orders, track progress, and streamline your workflow.</p>

                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                        <input id="email" class="block w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                        <input id="password" class="block w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:bg-white focus:ring-0 text-gray-900" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                                
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition duration-200 uppercase tracking-wide text-sm">
                            Log In
                        </button>

                        <a href="{{ route('register') }}" class="block text-center w-full mt-4 bg-gray-600 hover:bg-gray-700 text-black font-bold py-3 px-4 rounded-lg shadow-lg transition duration-200 uppercase tracking-wide text-sm">
                            Register New Account
                        </a>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>