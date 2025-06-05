<?php
namespace App\Livewire;

use App\Models\Loan;
use App\Models\ReturnItem;
use App\Models\Item;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use DB;

class ReturnItemController extends Component
{
    use WithPagination;

    public $loanId;
    public $returnDate;
    public $condition = 'good';
    public $penalty;
    public $note;
    public $selectedItems = [];

    protected $rules = [
        'returnDate' => 'required|date',
        'condition'  => 'required|in:good,damaged,lost',
        'penalty'    => 'nullable|numeric|min:0',
        'note'       => 'nullable|string|max:255',
        'selectedItems' => 'required|array|min:1',
    ];

    public function mount($loanId)
    {
        $this->loanId = $loanId;
    }

    public function render()
    {
        $loan = Loan::find($this->loanId);
        $items = $loan->loanItems->map(function ($loanItem) {
            return [
                'item' => $loanItem->item,
                'quantity' => $loanItem->quantity,
            ];
        });

        return view('livewire.return-form', [
            'loan' => $loan,
            'items' => $items,
        ])->layout('layouts.app');
    }

    public function submitReturn()
    {
        $this->validate();

        $loan = Loan::find($this->loanId);
        DB::transaction(function () use ($loan) {
            foreach ($this->selectedItems as $itemId => $quantity) {
                $item = Item::findOrFail($itemId);

                // Insert return item record
                ReturnItem::create([
                    'loan_id'     => $this->loanId,
                    'item_id'     => $itemId,
                    'return_date' => $this->returnDate,
                    'conditional' => $this->condition,
                    'penalty'     => $this->penalty,
                    'note'        => $this->note,
                ]);

                // Update item stock
                $item->increment('stock', $quantity);
            }

            // Optionally, update loan status to 'returned' or 'late' if overdue
            $loan->update(['status' => 'returned']);
        });

        session()->flash('success', 'Barang berhasil dikembalikan.');
        return redirect()->route('loans.show');
    }
}
