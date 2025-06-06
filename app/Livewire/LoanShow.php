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
                } //nampilin error (better pake flash message tp error)
                $item->decrement('stock', $loanItem->quantity);
            }
            $loan->update(['status' => 'approved']);
        });

        session()->flash('success', 'Peminjaman telah di-approve, stok barang otomatis berkurang.');
    }

    public function render()
    {
        $query = Loan::with(['user', 'loanItems.item']);

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

    public function deleteLoan($loanId)
    {
        $loan = Loan::findOrFail($loanId);

        \DB::transaction(function () use ($loan) {
            foreach ($loan->loanItems as $loanItem) {
                $item = $loanItem->item;
                $item->increment('stock', $loanItem->quantity);
            }
            $loan->delete();
        });

        session()->flash('success', 'Peminjaman telah dihapus, stok barang dikembalikan.');
    }
}

// student hanya bisa melihat peminjaman yang ia lakukan, tetapi teacher bisa melihat semua peminjaman yang dilakukan oleh student. apabila stok barang tidak mencukupi, maka peminjaman tidak bisa di-approve dan akan menampilkan pesan error. apabila peminjaman sudah di-approve, maka stok barang otomatis berkurang.
// apabila peminjaman sudah di-approve, maka status peminjaman akan berubah menjadi approved. apabila peminjaman sudah di-approve, maka tidak bisa di-approve lagi dan akan menampilkan pesan error. apabila peminjaman sudah di-approve, maka stok barang otomatis berkurang. Sediakan button delete untuk menghapus peminjaman ya (untuk guru dan siswa). Apabila peminjaman dihapus, maka stok barang akan dikembalikan ke jumlah semula. Apabila peminjaman dihapus. jangan pake throw new exception untuk ngasi error, tapi pake session flash message aja ya. Apabila peminjaman dihapus, maka akan menampilkan pesan sukses. Apabila peminjaman dihapus, maka stok barang akan dikembalikan ke jumlah semula.
