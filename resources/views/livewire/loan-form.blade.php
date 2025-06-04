<div class="p-8 max-w-6xl mx-auto text-black dark:text-white">
    <h1 class="text-2xl font-bold mb-6">Form Peminjaman Alat</h1>

    {{-- Alert sukses --}}
    @if (session()->has('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 dark:bg-green-900 text-green-800 dark:text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submitLoan" class="bg-white dark:bg-slate-800 rounded shadow p-6 mb-8 space-y-4">
        {{-- Tanggal Pinjam --}}
        <div class="grid grid-cols-1 md:grid-cols-2 space-x-2">
            <div>
                <label class="block font-semibold mb-1">Tanggal Pinjam <span class="text-red-500 text-sm">*</span></label>
                <input type="date" wire:model="loan_date"
                    class="w-full border rounded px-3 py-2 dark:bg-slate-700 dark:border-gray-600" />
                @error('loan_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tanggal Rencana Kembali --}}
            <div>
                <label class="block font-semibold mb-1">Rencana Mengembalikan <span class="text-red-500 text-sm">*</span></label>
                <input type="date" wire:model="return_date"
                    class="w-full border rounded px-3 py-2 dark:bg-slate-700 dark:border-gray-600" />
                @error('return_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Daftar Alat --}}
        <div>
            <label class="block font-semibold mb-2">Pilih Alat <span class="text-red-500 text-sm">*max 2 barang</span> </label>

            <div class="grid grid-cols-3 gap-4">
                @foreach ($items as $item)
                    <div class="flex items-center justify-center space-x-2">
                        {{-- Checkbox --}}
                        <input type="checkbox" wire:model="selectedItems" value="{{ $item->id }}"
                            id="item-{{ $item->id }}"
                            class="mt-1 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />

                        {{-- Detail Alat + jumlah & note --}}
                        <div class="flex items-center justify-center space-y-1">
                            <label for="item-{{ $item->id }}" class="font-medium">
                                {{ $item->name }} (Stok: {{ $item->stock }})
                            </label>

                            @if (isset($item->id, $selectedItems))
                                {{-- Jumlah --}}
                                <div>
                                    <label class="text-sm">Jumlah Barang:</label>
                                    <input type="number" wire:model.defer="quantities.{{ $item->id }}"
                                        min="1" max="{{ $item->stock }}"
                                        class="w-full border rounded px-2 py-1 dark:bg-slate-700 dark:border-gray-600" />
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                <label class="font-semibold">Catatan (opsional):</label>
                <textarea wire:model.defer="notes.{{ $item->id }}"
                    class="w-full border rounded px-2 py-1 dark:bg-slate-700 dark:border-gray-600" rows="2"></textarea>
            </div>

            @error('selectedItems')
            <div class="mb-4 px-4 py-3 bg-red-100 dark:bg-red-900 text-red-800 dark:text-white rounded">
                <span class="text-sm">{{ $message }}</span>
            </div>
            @enderror
        </div>

        {{-- Tombol Submit --}}
        <div class="text-right">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Ajukan Peminjaman
            </button>
        </div>
    </form>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div>
