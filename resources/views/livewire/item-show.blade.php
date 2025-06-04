@php use Illuminate\Support\Str; @endphp

{{-- <x-app-layout> --}}
<div class="mx-auto mt-14">
    <div class="p-8 max-w-6xl mx-auto text-black dark:text-white">

        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold mb-6">Daftar Barang</h1>

            <div class="mb-4">
                <a href="{{ url('/items/create') }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ Tambah Barang</a>
            </div>
        </div>

        <table class="w-full table-auto border">
            <thead>
                <tr class="bg-gray-100 dark:bg-slate-700">
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Gambar</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Stok</th>
                    <th class="border px-4 py-2">Deskripsi</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $index => $item)
                    <tr>
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">
                            @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" class="h-20 mx-auto">
                            @else
                                <span class="text-gray-400 italic">tidak ada</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $item->name }}</td>
                        <td class="border px-4 py-2">{{ $item->stock }}</td>
                        <td class="border px-4 py-2">{{ $item->description }}</td>
                        <td class="border px-4 py-1 space-x-2 text-center">
                            <a href="{{ route('items.edit', ['slug' => \Str::slug($item->name)]) }}"
                                class="bg-yellow-500 w-24 p-2 rounded text-white">Edit</a>
                            <button wire:click="destroy({{ $item->id }})"
                                class="bg-red-600 w-16 p-1 rounded text-white"
                                onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $items->links() }}
        </div>
    </div>
</div>

{{-- </x-app-layout> --}}
