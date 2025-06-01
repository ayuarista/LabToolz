@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Form Peminjaman</h1>

    <form action="{{ route('loans.store') }}" method="POST">
        @csrf

        <label>Tanggal Peminjaman</label>
        <input type="date" name="loan_date" class="border rounded p-2 w-full mb-2" required>

        <label>Tanggal Pengembalian</label>
        <input type="date" name="return_date" class="border rounded p-2 w-full mb-2" required>

        <h2 class="text-xl mt-4 mb-2">Barang</h2>

        @foreach ($items as $item)
            <div class="flex items-center gap-2 mb-2">
                <input type="checkbox" name="items[{{ $loop->index }}][item_id]" value="{{ $item->id }}">
                <label>{{ $item->name }} (stok: {{ $item->stock }})</label>
                <input type="number" name="items[{{ $loop->index }}][quantity]" min="1" class="border rounded p-1 w-20" placeholder="Jumlah">
            </div>
        @endforeach

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-4">Pinjam</button>
    </form>
</div>
@endsection
