<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\History;

class HistoryController extends Component
{
    public $logs;

    public function mount()
    {
        $this->logs = History::latest()->get();
    }
    public function render()
    {
        return view('livewire.history-controller');
    }
}