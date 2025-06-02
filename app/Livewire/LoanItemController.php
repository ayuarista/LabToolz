<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LoanItem;
use App\Models\Loan;
use App\Models\Item;

class LoanItemController extends Component
{
    public $loanItems;

    public function mount()
    {
        $this->loanItems = LoanItem::with(['loan', 'item'])->get();
    }

    public function render()
    {
        return view('livewire.loan-item-controller');
    }
}

