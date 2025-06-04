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

    // Menangani aksi approve (guru/admin)
    public function approve($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        if ($loan->status !== 'pending') {
            session()->flash('error', 'Peminjaman sudah diproses sebelumnya.');
            return;
        }

        \DB::transaction(function () use ($loan) {
            // Periksa stok dan kurangi stok setiap item
            foreach ($loan->loanItems as $loanItem) {
                $item = $loanItem->item;
                if ($item->stock < $loanItem->quantity) {
                    throw new \Exception("Stok " . $item->name . " tidak mencukupi.");
                }
                $item->decrement('stock', $loanItem->quantity);
            }
            // Update status loan menjadi 'approved'
            $loan->update(['status' => 'approved']);
        });

        session()->flash('success', 'Peminjaman telah di-approve, stok barang otomatis terpotong.');
    }

    // Menangani pengembalian alat (ubah status jadi 'returned')

    public function markReturned($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        if ($loan->status !== 'approved') {
            session()->flash('error', 'Hanya peminjaman yang sudah di-approve yang bisa dikembalikan.');
            return;
        }

        \DB::transaction(function () use ($loan) {
            // Kembalikan stok setiap item
            foreach ($loan->loanItems as $loanItem) {
                $item = $loanItem->item;
                $item->increment('stock', $loanItem->quantity);
            }
            // Update status loan menjadi 'returned'
            $loan->update(['status' => 'returned']);
        });

        session()->flash('success', 'Barang berhasil ditandai dikembalikan, stok telah dikembalikan.');
    }

    public function render()
    {
        // Query basic
        $query = Loan::with(['user', 'loanItems.item']);

        // Filter berdasarkan status
        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        // Jika user role student, hanya tampilkan miliknya
        if (Auth::user()->hasRole('student')) {
            $query->where('user_id', Auth::id());
        }

        // Pagination 10 per halaman
        $loans = $query->latest()->paginate(10);

        return view('livewire.loan-show', compact('loans'))->layout('layouts.app');
    }
}