<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Loan;
use App\Models\User;

class LoanController extends Component
{
    public $loans;

    public function mount()
    {
        $this->loans = Loan::with('user')->get();
    }
    public function render()
    {
        return view('livewire.loan-controller');
    }
}
