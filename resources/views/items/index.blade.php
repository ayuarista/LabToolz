@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Daftar Barang</h1>
    <a href="{{ route('items.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Barang</a>

    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2">Nama</th>
                <th class="p-2">Stok</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td class="p-2">{{ $item->name }}</td>
                <td class="p-2">{{ $item->stock }}</td>
                <td class="p-2 flex gap-2">
                    <a href="{{ route('items.edit', $item) }}" class="text-blue-600">Edit</a>
                    <form method="POST" action="{{ route('items.destroy', $item) }}">
                        @csrf @method('DELETE')
                        <button class="text-red-600" onclick="return confirm('Hapus barang?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
