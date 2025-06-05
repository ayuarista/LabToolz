<div class="p-8 max-w-6xl mx-auto text-black dark:text-white space-y-6">
    <h1 class="text-2xl font-bold">Pengembalian Alat</h1>

    {{-- Alert Sukses/Error --}}
    @if (session()->has('success'))
        <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @elseif (session()->has('error'))
        <div class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-4 py-2 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="submitReturn" class="bg-white dark:bg-slate-800 rounded shadow p-6 mb-8 space-y-4">
        {{-- Tanggal Pengembalian --}}
        <div>
            <label class="block font-semibold mb-1">Tanggal Pengembalian</label>
            <input type="date"
                   wire:model="returnDate"
                   class="w-full border rounded px-3 py-2 dark:bg-slate-700 dark:border-gray-600" />
            @error('returnDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Pilih Alat --}}
        <div>
            <label class="block font-semibold mb-1">Pilih Alat yang Dikembalikan</label>
            @foreach ($items as $item)
                <div class="flex items-center space-x-2 mb-4">
                    <input type="checkbox" wire:model="selectedItems.{{ $item['item']->id }}" value="{{ $item['quantity'] }}" class="rounded">
                    <span>{{ $item['item']->name }} (Stok tersedia: {{ $item['item']->stock }})</span>
                    <input type="number" wire:model="quantity.{{ $item['item']->id }}" min="1" max="{{ $item['quantity'] }}" class="w-20 px-2 py-1 dark:bg-slate-700 dark:border-gray-600">
                </div>
            @endforeach
            @error('selectedItems') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Pilih Kondisi --}}
        <div>
            <label class="block font-semibold mb-1">Kondisi Barang</label>
            <select wire:model="condition" class="w-full rounded px-3 py-2 dark:bg-slate-700 dark:border-gray-600">
                <option value="good">Baik</option>
                <option value="damaged">Rusak</option>
                <option value="lost">Hilang</option>
            </select>
            @error('condition') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Penalti --}}
        <div>
            <label class="block font-semibold mb-1">Penalti (Jika Ada)</label>
            <input type="number" wire:model="penalty" min="0" class="w-full border rounded px-3 py-2 dark:bg-slate-700 dark:border-gray-600" />
            @error('penalty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Catatan --}}
        <div>
            <label class="block font-semibold mb-1">Catatan (Opsional)</label>
            <textarea wire:model="note" class="w-full border rounded px-3 py-2 dark:bg-slate-700 dark:border-gray-600"></textarea>
            @error('note') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Tombol Submit --}}
        <div class="text-right">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Proses Pengembalian
            </button>
        </div>
    </form>
</div>
