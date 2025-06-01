@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Tambah Barang</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Nama Barang</label>
            <input type="text" name="name" id="name" class="w-full border rounded p-2" placeholder="Contoh: Laptop" required value="{{ old('name') }}">
        </div>

        <div class="mb-4">
            <label for="description" class="block font-semibold mb-1">Deskripsi (opsional)</label>
            <textarea name="description" id="description" rows="3" class="w-full border rounded p-2" placeholder="Keterangan tambahan">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="stock" class="block font-semibold mb-1">Stok Barang</label>
            <input type="number" name="stock" id="stock" class="w-full border rounded p-2" min="1" required value="{{ old('stock') }}">
        </div>

        <div class="mb-4">
            <label for="image" class="block font-semibold mb-1">Foto Barang (opsional)</label>
            <input type="file" name="image" id="image" class="w-full border rounded p-2">
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('items.index') }}" class="text-gray-600 hover:underline">Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
