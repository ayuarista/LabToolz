<?php

namespace App\Livewire;

use DB;
use App\Models\Item;
use App\Models\Loan;
use Livewire\Component;
use App\Models\LoanItem;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class LoanShow extends Component
{
    use WithPagination;

    public $filterStatus = 'all';

    public function approve($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        if ($loan->status !== 'pending') {
            session()->flash('error', 'Peminjaman sudah diproses sebelumnya.');
            return;
        }

        \DB::transaction(function () use ($loan) {
            foreach ($loan->loanItems as $loanItem) {
                $item = $loanItem->item;
                if ($item->stock < $loanItem->quantity) {
                    throw new \Exception("Stok " . $item->name . " tidak mencukupi.");
                }
                $item->decrement('stock', $loanItem->quantity);
            }
            $loan->update(['status' => 'approved']);
        });

        session()->flash('success', 'Peminjaman telah di-approve, stok barang otomatis terpotong.');
    }

    public function markReturned($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        if ($loan->status !== 'approved') {
            session()->flash('error', 'Hanya peminjaman yang sudah di-approve yang bisa dikembalikan.');
            return;
        }

        \DB::transaction(function () use ($loan) {
            foreach ($loan->loanItems as $loanItem) {
                $item = $loanItem->item;
                $item->increment('stock', $loanItem->quantity);
            }
            $loan->update(['status' => 'returned']);
        });

        session()->flash('success', 'Barang berhasil ditandai dikembalikan, stok telah dikembalikan.');
    }

    public function render()
    {
        $query = Loan::with(['user', 'loanItems.item']);

        // Filter berdasarkan status
        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if (Auth::user()->hasRole('student')) {
            $query->where('user_id', Auth::id());
        }

        $loans = $query->latest()->paginate(10);

        $isTeacher = Auth::user()->hasRole('teacher');

        return view('livewire.loan-show', compact('loans', 'isTeacher'))->layout('layouts.app');
    }
}
