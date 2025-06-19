<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Loan;
use App\Models\Admin;
use Livewire\Component;
use App\Models\ReturnItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReturnForm extends Component
{
    public $loanId;
    public $returnDate;
    public $items = [];
    public $conditions = [];
    public $notes = [];

    public function mount($loanId)
    {

        if (!Auth::user()->hasRole('teacher')) {
            abort(403);
        }


        $this->loanId = $loanId;
        $loan = Loan::with('loanItems.item')->findOrFail($loanId);

        foreach ($loan->loanItems as $loanItem) {
            $this->items[] = [
                'id' => $loanItem->item->id,
                'name' => $loanItem->item->name,
                'quantity' => $loanItem->quantity
            ];

            $this->conditions[$loanItem->item->id] = 'good';
            $this->notes[$loanItem->item->id] = '';
        }
    }

    public function submit()
    {
        $this->validate([
            'returnDate' => 'required|date',
            'conditions' => 'required|array',
            'notes' => 'nullable|array'
        ]);

        foreach ($this->items as $item) {
            ReturnItem::create([
                'loan_id' => $this->loanId,
                'item_id' => $item['id'],
                'return_date' => $this->returnDate,
                'conditional' => $this->conditions[$item['id']],
                'note' => $this->notes[$item['id']],
                'penalty' => $this->conditions[$item['id']] !== 'good' ? 5000 : 0,
            ]);

            if (in_array($this->conditions[$item['id']], ['good', 'damaged'])) {
                Item::find($item['id'])->increment('stock', $item['quantity']);
            }
        }

        Loan::find($this->loanId)->update(['status' => 'returned']);

        session()->flash('success', 'Barang berhasil dikembalikan.');
        return redirect()->route('return.show');
    }

    public function render()
    {
        return view('livewire.return-form')->layout('layouts.app');
    }
}
