<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::with('user')->latest()->get();
        return view('loans.index', compact('loans'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        return view('loans.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:loan_date',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try{
            $loan = Loan::create([
                'user_id' => auth()->id(),
                'loan_date' => $validated['loan_date'],
                'return_date' => $validated['return_date'],
                'status' => 'pending',
            ]);

            foreach ($validated['items'] as $itemData) {
                $item = Item::findOrFail($itemData['item_id']);
                if ($item->stock < $itemData['quantity']) {
                    throw new \Exception("Tidak ada stok untuk barang {$item->name}");
                }
                $item->decrement('stock', $itemData['quantity']);

                $loan->loanItems()->create([
                    'item_id' => $itemData['item_id'],
                    'quantity' => $itemData['quantity']
                ]);
            }
            DB::commit();
            return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil dibuat.');

        } catch (\Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        $loan->load(['loanItems.item', 'user']);
        return view('loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,returned,late',
        ]);
        $loan->update(['status' => $validated['status']]);

        return back()->with('success', 'Status peminjaman berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
