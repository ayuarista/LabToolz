<div class="p-6 text-black dark:text-white">
    <h1 class="text-2xl font-bold mb-4">Form Pengembalian Barang</h1>

    @if (session()->has('success'))
        <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label for="returnDate" class="font-semibold">Tanggal Pengembalian</label>
            <input type="date" wire:model="returnDate" class="w-full px-3 py-2 rounded border dark:bg-gray-700" required>
        </div>

        @foreach ($items as $item)
            <div class="p-4 border rounded bg-white dark:bg-gray-800 shadow">
                <h2 class="font-bold">{{ $item['name'] }} (x{{ $item['quantity'] }})</h2>
                <label>Kondisi:</label>
                <select wire:model="conditions.{{ $item['id'] }}" class="w-full rounded px-3 py-2 dark:bg-gray-700">
                    <option value="good">Baik</option>
                    <option value="damaged">Rusak</option>
                    <option value="lost">Hilang</option>
                </select>
                <label class="block mt-2">Catatan:</label>
                <textarea wire:model="notes.{{ $item['id'] }}" class="w-full rounded px-3 py-2 dark:bg-gray-700"></textarea>
            </div>
        @endforeach

        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Kembalikan</button>
    </form>
</div>
