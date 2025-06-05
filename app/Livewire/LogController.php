<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Log;

class LogController extends Component
{
    public $logs;

    public function mount()
    {
        $this->logs = Log::latest()->get();
    }
    public function render()
    {
        return view('livewire.log-controller');
    }
}