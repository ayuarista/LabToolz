<x-register-wrapper>
    <div class="min-h-screen flex items-center justify-center bg-gray-900 px-4">
        <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="text-left">
                <h2 class="text-4xl font-[800] text-gray-800 dark:text-white">Selamat Datang! 👋</h2>
                <p class="text-base text-gray-500 dark:text-gray-400">Ayo buat akun mu sekarang</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block mb-2 text-lg font-semibold text-gray-900 dark:text-white">
                        Nama <span class="text-red-500">*</span></label>
                    <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus
                        autocomplete="name"
                        class="block w-full p-2.5 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm lg:text-base rounded-lg
                    focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-400" />
                </div>
                <div>
                    <label for="email" class="block mb-2 text-lg font-semibold text-gray-900 dark:text-white">
                        Email <span class="text-red-500">*</span></label>
                    <x-text-input id="email" name="email" type="email" :value="old('email')" required
                        autocomplete="username"
                        class="block w-full p-2.5 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm lg:text-base rounded-lg
                    focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-400" />
                </div>

                <div>
                    <label for="password" class="block mb-2 text-lg font-semibold text-gray-900 dark:text-white">
                        Kata Sandi <span class="text-red-500">*</span></label>
                    <x-text-input id="password" name="password" type="password" required autocomplete="new-password"
                        class="block w-full p-2.5 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                    focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 lg:text-base" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-400" />
                </div>

                <div>
                    <label for="password_confirmation"
                        class="block mb-2 text-lg font-semibold text-gray-900 dark:text-white">Konfirmasi Kata Sandi<span
                            class="text-red-500">*</span></label>
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" required
                        autocomplete="new-password"
                        class="block w-full p-2.5 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm lg:text-base rounded-lg
                    focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-red-400" />
                </div>

                <button type="submit"
                    class="w-full flex justify-center items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-lg rounded-lg transition focus:ring-2 focus:ring-indigo-300 dark:focus:ring-indigo-500">
                    Buat Akun
                </button>

                <div class="text-base font-medium text-gray-500 dark:text-gray-400">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}"
                        class="text-indigo-700 underline dark:text-indigo-500">Masuk</a>
                </div>
            </form>
        </div>
    </div>

</x-register-wrapper>
