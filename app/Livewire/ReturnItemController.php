<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ReturnItem;

class ReturnItemController extends Component
{
    public $returns;

    public function mount()
    {
        $this->returns = ReturnItem::with('loanItem')->get();
    }
    public function render()
    {
        return view('livewire.return-item-controller');
    }
}
