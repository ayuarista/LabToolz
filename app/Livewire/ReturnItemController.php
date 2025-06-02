<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ReturnItem;

class ReturnController extends Component
{
    public $returns;

    public function mount()
    {
        $this->returns = ReturnItem::with('loanItem')->get();
    }
    public function render()
    {
        return view('livewire.return-controller');
    }
}
