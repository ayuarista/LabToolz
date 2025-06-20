<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\History;

class HistoryController extends Component
{
    public function render()
    {
        return view('livewire.history-controller');
    }
}