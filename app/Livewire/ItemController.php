<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;

class ItemController extends Component
{
    public $items;
    public function mount()
    {
        $this->items = Item::all();

    }
    public function render()
    {
        return view('livewire.item-controller');
    }
}
