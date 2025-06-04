<?php

namespace App\Livewire;

use App\Models\Item as ItemModel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Item extends Component
{
    use WithPagination, WithFileUploads;

    public $itemId, $name, $description, $stock, $image, $newImage;
    public $isEdit = false;
    public $slug;
    public $preview;

    protected function rules()
    {
        $slug = Str::slug(str_replace(['[', ']'], '', $this->name));
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'newImage' => $this->isEdit ? 'nullable|image' : 'required|image',
            'slug' => 'unique:items,slug,' . $this->itemId
        ];
    }

    public function mount($slug = null)
    {
        if ($slug) {
            $slug = str_replace(['[', ']'], '', $slug);
            $item = ItemModel::where('slug', Str::slug($slug))->firstOrFail();
            $this->itemId = $item->id;
            $this->name = $item->name;
            $this->description = $item->description;
            $this->stock = $item->stock;
            $this->image = $item->image;
            $this->isEdit = true;
        }
    }

    public function updatedNewImage()
    {
        $this->preview = $this->newImage->temporaryUrl();
    }


    public function render()
    {
        return view('livewire.item')->layout('layouts.app');
    }

    public function resetInput()
    {
        return redirect('/items');
    }

    public function store()
    {
        $this->slug = Str::slug(str_replace(['[', ']'], '', $this->name));
        $this->validate();

        if (!$this->newImage) {
            $this->dispatch('notify', [
                'title' => 'Gagal!',
                'text' => 'Gambar wajib diupload.',
                'icon' => 'error'
            ]);
            return;
        }

        $path = $this->newImage->store('items', 'public');

        ItemModel::create([
            'name' => $this->name,
            'description' => $this->description,
            'stock' => $this->stock,
            'image' => $path,
            'slug' => $this->slug,
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Item berhasil ditambahkan.'
        ]);

        return redirect('/items');
    }
    public function testNotify()
    {
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Ini dari Livewire!'
        ]);
    }

    public function update()
    {
        $this->slug = Str::slug(str_replace(['[', ']'], '', $this->name));
        $this->validate();

        $item = ItemModel::findOrFail($this->itemId);
        $path = $this->image;

        if ($this->newImage) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $path = $this->newImage->store('items', 'public');
        }

        $item->update([
            'name' => $this->name,
            'description' => $this->description,
            'stock' => $this->stock,
            'image' => $path,
            'slug' => $this->slug,
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
    'message' => 'Item berhasil diperbarui.'
        ]);

        return redirect('/items');
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete', ['id' => $id]);
    }

    public function destroy($id)
    {
        $item = ItemModel::findOrFail($id);

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        $this->dispatch('swal', [
            'title' => 'Dihapus!',
            'text' => 'Item berhasil dihapus.',
            'icon' => 'success'
        ]);
    }
}
