<div class="p-6 text-black dark:text-white">
    <h1 class="text-2xl font-bold mb-4">Daftar Pengembalian Barang</h1>

    <table class="w-full table-auto border border-gray-300 dark:border-gray-600">
        <thead>
            <tr class="bg-gray-200 dark:bg-gray-700">
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Nama Peminjam</th>
                <th class="px-4 py-2">Barang</th>
                <th class="px-4 py-2">Tanggal Kembali</th>
                <th class="px-4 py-2">Kondisi</th>
                <th class="px-4 py-2">Catatan</th>
                <th class="px-4 py-2">Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($returnItems as $index => $return)
                <tr class="border-t dark:border-gray-700">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $return->loan->user->name }}</td>
                    <td class="px-4 py-2">{{ $return->item->name }}</td>
                    <td class="px-4 py-2">{{ $return->return_date }}</td>
                    <td class="px-4 py-2">{{ ucfirst($return->conditional) }}</td>
                    <td class="px-4 py-2">{{ $return->note ?? '-' }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($return->penalty ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
