<x-register-wrapper>
    <div class="flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-4">
        <div class="w-full max-w-xl bg-white dark:bg-gray-800 rounded-xl p-8 space-y-6">
    
            <div class="text-center">
                <h2 class="text-4xl font-bold text-gray-800 dark:text-white">Halo! 👋</h2>
                <p class="text-[17px] text-gray-500 dark:text-gray-400 mt-2">Ayo masuk kembali ke akun mu</p>
            </div>
    
            <x-auth-session-status class="mb-4 text-[17px]" :status="session('status')" />
    
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
    
                <div>
                    <label for="email" class="block text-lg font-semibold text-gray-700 dark:text-gray-300">Email <span
                            class="text-red-500">*</span>
                    </label>
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                        autocomplete="username" class="mt-1 w-full" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-base" />
                </div>
    
                <div>
                    <label for="password" class="block text-lg font-semibold text-gray-700 dark:text-gray-300">Kata Sandi <span
                            class="text-red-500">*</span></label>
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                        class="mt-1 w-full" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-base" />
                </div>
    
                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-[17px] text-gray-600 dark:text-gray-400">
                        <input type="checkbox" name="remember"
                            class="mr-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        Ingat Saya
                    </label>
    
                    {{-- @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-base text-indigo-600 hover:underline dark:text-indigo-400">
                                    Forgot password?
                                </a>
                            @endif --}}
                </div>
    
                <!-- Login button -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-lg rounded-lg transition focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-500">
                        Masuk
                    </button>
                </div>
            </form>
    
            <!-- Register link -->
            <p class="text-center text-base text-gray-600 dark:text-gray-400">
                Belum mempunyai akun?
                <a href="{{ route('register') }}" class="text-primary-600 underline dark:text-indigo-500">Buat Akun</a>
            </p>
        </div>
    </div>
</x-register-wrapper>
