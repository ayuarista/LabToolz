<div class="p-8 max-w-6xl mx-auto text-black dark:text-white">
    <h1 class="text-2xl font-bold mb-6">{{ $isEdit ? 'Edit Item' : 'Tambah Item' }}</h1>

    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" enctype="multipart/form-data" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label>Nama</label>
                <input type="text" wire:model.defer="name" class="w-full rounded border p-2 dark:bg-slate-800 bg-white">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Stok</label>
                <input type="number" wire:model.defer="stock" class="w-full rounded border p-2 dark:bg-slate-800 bg-white">
                @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2">
                <label>Deskripsi</label>
                <textarea wire:model.defer="description" class="w-full rounded border p-2 dark:bg-slate-800 bg-white"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="col-span-2">
                <label>Gambar</label>
                <div class="w-full border-2 border-dashed border-indigo-500 rounded-md p-4 text-center relative">
                    <label class="cursor-pointer flex flex-col items-center justify-center space-y-2 text-gray-500 dark:text-gray-300">
                        <ion-icon name="images" class="text-4xl"></ion-icon>
                        <span class="text-sm">Klik di sini untuk upload gambar</span>
                        <input type="file" wire:model="newImage" class="hidden" />
                    </label>

                    @error('newImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    @if ($preview)
                        <div class="mt-2">
                            <img src="{{ $preview }}" class="mx-auto max-h-48 rounded-md shadow" alt="Preview">
                        </div>
                    @elseif ($image)
                        <div class="mt-4">
                            <img src="{{ asset('storage/' . $image) }}" class="mx-auto max-h-48 rounded-md shadow" alt="Gambar Lama">
                        </div>
                    @endif

                    @if ($newImage)
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                            <strong>Dipilih:</strong> {{ $newImage->getClientOriginalName() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <div class="flex items-end justify-end space-x-2">
            <button type="button" wire:click="resetInput" class="bg-gray-400 px-4 py-2 rounded hover:bg-gray-500">
                Batal {{ $isEdit ? 'Edit' : '' }}
            </button>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                {{ $isEdit ? 'Update Item' : 'Tambah Item' }}
            </button>
        </div>
    </form>
</div>
