<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ItemShow extends Component
{
    use WithPagination;

    public function render()
    {
        $items = Item::latest()->paginate(10);
        return view('livewire.item-show', compact('items'))->layout('layouts.app');
    }

    public function destroy($id)
{
    $item = Item::findOrFail($id);
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
