<x-register-wrapper>
    <div class="flex flex-col items-center justify-center h-screen">
        <img src="{{ asset('assets/404.svg') }}" alt="Page not found" class="mx-auto max-w-sm">
        <div class="text-center xl:max-w-4xl">
            <h1 class="text-indigo-600 text-4xl font-bold">404</h1>
            <h1 class="mb-3 text-2xl lg:text-3xl font-bold leading-tight text-gray-900 dark:text-white">Halaman tidak ditemukan</h1>
            <div class="mt-6">
                <a href="{{ route('dashboard') }}" class="px-7 py-3 rounded-full bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 text-white font-medium text-xl">Kembali ke dashboard</a>
            </div>
        </div>
    </div>
</x-register-wrapper>
