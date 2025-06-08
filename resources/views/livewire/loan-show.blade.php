<div class="p-8 max-w-6xl mx-auto text-black dark:text-white space-y-6">
    <h1 class="text-2xl font-bold">Daftar Peminjaman</h1>

    {{-- Alert Sukses/Error --}}
    @if (session()->has('success'))
        <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-white px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @elseif (session()->has('error'))
        <div class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-4 py-2 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if (auth()->user()->role == 'student')
        <div class="text-right">
            <a href="{{ route('loans.form') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
               Ajukan Peminjaman
            </a>
        </div>
    @endif

    @if (auth()->user()->role == 'teacher')
        <div class="flex items-center space-x-4">
            <label class="font-semibold">Filter Status:</label>
            <select wire:model="filterStatus"
                    class="border rounded px-2 py-1 dark:bg-slate-700 dark:border-gray-600">
                <option value="all">Semua</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="returned">Returned</option>
                <option value="late">Late</option>
            </select>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 rounded shadow p-4 overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-gray-100 dark:bg-slate-700">
                <tr>
                    <th class="border px-4 py-2 text-left">No</th>
                    <th class="border px-4 py-2 text-left">Nama</th>
                    <th class="border px-4 py-2 text-left">Kelas</th>
                    <th class="border px-4 py-2 text-left">Tgl. Pinjam</th>
                    <th class="border px-4 py-2 text-left">Tgl. Mengembalikan</th>
                    <th class="border px-4 py-2 text-left">Status</th>
                    <th class="border px-4 py-2 text-left">Detail Alat</th>
                    @if (auth()->user()->role == 'teacher')
                        <th class="border px-4 py-2 text-center">Aksi</th>
                    @elseif (auth()->user()->role == 'student' && $filterStatus === 'pending')
                        <th class="border px-4 py-2 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($loans as $loan)
                    <tr class="border-t dark:border-gray-700">
                        <td class="px-4 py-2">{{ $loop->iteration + ($loans->currentPage()-1)*$loans->perPage() }}</td>
                        <td class="px-4 py-2">{{ $loan->user->name }}</td>
                        <td class="px-4 py-2">{{ $loan->user->role }}</td>
                        <td class="px-4 py-2">{{ $loan->loan_date }}</td>
                        <td class="px-4 py-2">{{ $loan->return_date }}</td>
                        <td class="px-4 py-2">
                            @if ($loan->status === 'late')
                                <span class="px-2 py-1 bg-red-100 text-red-600 rounded-md text-sm font-semibold">{{ $loan->status }}</span>
                            @elseif ($loan->status === 'approved')
                                <span class="px-2 py-1 bg-green-100 text-green-600 rounded-md text-sm font-semibold">{{ $loan->status }}</span>
                            @elseif($loan->status === 'returned')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-md text-sm font-semibold">{{ $loan->status }}</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-md text-sm font-semibold">{{ $loan->status }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <ul class="space-y-1">
                                @foreach ($loan->loanItems as $detail)
                                    <li class="flex items-center space-x-2">
                                        <span class="font-medium">{{ $detail->item->name }}</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">
                                            (x{{ $detail->quantity }})
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">
                            @if (auth()->user()->role == 'teacher' && $loan->status === 'pending')
                                <button wire:click="approve({{ $loan->id }})"
                                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                                    Approve
                                </button>
                            @endif

                            {{-- @if (auth()->user()->role == 'teacher' && $loan->status === 'approved')
                                <a href="{{ route('loans.return', $loan->id) }}" class="text-white px-4 py-2 rounded bg-blue-600 hover:bg-blue-700">
                                    Return
                                </a>
                            @endif --}}



                            {{-- @if (auth()->user()->role == 'student' && $loan->status === 'approved')
                                <button wire:click="markReturned({{ $loan->id }})"
                                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                    Kembalikan
                                </button>
                            @endif --}}
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">
                            @if (auth()->user()->role == 'teacher')
                                <button wire:click="deleteLoan({{ $loan->id }})"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                    hapus
                                </button>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">
                            Belum ada data peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $loans->links() }}
        </div>
    </div>
</div>

