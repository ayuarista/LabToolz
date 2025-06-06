<?php

namespace App\Livewire;

use App\Models\Loan;
use Livewire\Component;
use App\Models\ReturnItem;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class ReturnShow extends Component
{
    use WithPagination;

    public $returnItems;

    public function mount()
    {
        if (!Auth::user()->hasRole('teacher')) {
            abort(403);
        }

        $this->returnItems = ReturnItem::with(['loan.user', 'item'])->latest()->get();
    }
    public function render()
    {
        return view('livewire.return-show')->layout('layouts.app');
    }
}
