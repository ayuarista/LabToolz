<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Loan;
use App\Models\LoanItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class LoanForm extends Component
{
    use WithPagination;

    public $loan_date;
    public $return_date;
    public $selectedItems = [];
    public $quantities = [];
    public $notes = [];

    protected $rules = [
        'loan_date' => 'required|date',
        'return_date' => 'required|date|after_or_equal:loan_date',
        'selectedItems' => 'required|array|min:1|max:2',
    ];

    public function submitLoan()
    {
        $this->validate();

        DB::transaction(function () {
            $loan = Loan::create([
                'user_id' => Auth::id(),
                'loan_date' => $this->loan_date,
                'return_date' => $this->return_date,
                'status' => 'pending',
            ]);

            foreach ($this->selectedItems as $itemId) {
                $item = Item::findOrFail($itemId);
                $quantity = max(1, (int) ($this->quantities[$itemId] ?? 1));
                if ($item->stock < $quantity) {
                    session()->flash('error', "Stok untuk item {$item->name} tidak ada.");
                    return;
                }

                LoanItem::create([
                    'loan_id' => $loan->id,
                    'item_id' => $itemId,
                    'quantity' => $quantity,
                    'note' => $this->notes[$itemId] ?? null,
                ]);
            }
        });

        session()->flash('success', 'Peminjaman berhasil diajukan. Menunggu persetujuan.')->flash('error', 'Peminjaman gagal, silakan coba lagi.');
        $this->reset(['loan_date', 'return_date', 'selectedItems', 'quantities', 'notes']);
        return redirect('/loans');
    }

    public function render()
    {
        $items = Item::where('stock', '>', 0)->paginate(10);
        return view('livewire.loan-form', compact('items'))->layout('layouts.app');
    }
}
