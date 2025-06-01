<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Alat RPL</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-lg font-semibold">Peminjaman Alat RPL</h1>
            <div>
                <a href="{{ route('items.index') }}" class="hover:underline mr-4">Barang</a>
                <a href="{{ route('loans.index') }}" class="hover:underline">Peminjaman</a>
            </div>
        </div>
    </nav>

    <main class="flex-1 p-4">
        @yield('content')
    </main>

    <footer class="bg-gray-200 text-center p-2 text-sm">
        &copy; {{ date('Y') }} Peminjaman Alat RPL. All rights reserved.
    </footer>
</body>
</html>
