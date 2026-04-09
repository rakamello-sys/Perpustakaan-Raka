<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    // READ: Tampilkan semua transaksi
    public function index()
    {
        $transaction = Transaction::with(['user', 'book'])->latest()->get();
        return view('admin.transaction.index', compact('transaction'));
    }

    // CREATE: Form tambah transaksi
    public function create()
    {
        $users = User::where('role', 'siswa')->get(); // Ambil data siswa saja
        $books = Book::where('stok', '>', 0)->get(); // Perbaiki: Ambil buku yang ada stoknya
        return view('admin.transaction.create', compact('users', 'books'));
    }

    // STORE: Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required|in:pinjam,kembali'
        ]);

        // Cek stok buku lagi untuk keamanan
        $book = Book::findOrFail($request->book_id);

        if ($request->status == 'pinjam' && $book->stok < 1) {
            return back()->with('error', 'Stok buku habis!');
        }

        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => ($request->status == 'kembali') ? Carbon::now() : null,
            'status' => $request->status // Perbaiki: kutip dan variabel yang salah
        ]);

        // Kurangi stok jika statusnya pinjam
        if ($request->status == 'pinjam') { // Perbaiki: -> bukan -
            $book->decrement('stok'); // Perbaiki: -> bukan -
        }

        return redirect()->route('transaction.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    // EDIT: Form edit transaksi
    public function edit(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $users = User::where('role', 'siswa')->get();
        $books = Book::all(); // Tampilkan semua buku (termasuk yg stok 0, karena ini edit)
        return view('admin.transaction.edit', compact('transaction', 'users', 'books'));
    }

    // UPDATE: Simpan perubahan
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $book = Book::findOrFail($transaction->book_id);
        
        $request->validate([
            'status' => 'required|in:pinjam,kembali',
            'tanggal_pinjam' => 'required|date' // Perbaiki: kutip
        ]);

        // Logika Perubahan Stok berdasarkan perubahan Status
        // 1. Jika dulunya 'pinjam' -> sekarang diubah 'kembali' (Barang balik)
        if ($transaction->status == 'pinjam' && $request->status == 'kembali') {
            $book->increment('stok');
            $request->merge(['tanggal_kembali' => Carbon::now()]);
        } 
        // 2. Jika dulunya 'kembali' -> sekarang diubah 'pinjam' (Barang dipinjam lagi)
        elseif ($transaction->status == 'kembali' && $request->status == 'pinjam') {
            if ($book->stok < 1) {
                return back()->with('error', 'Stok buku tidak cukup untuk mengubah status menjadi pinjam.');
            }
            $book->decrement('stok');
            $request->merge(['tanggal_kembali' => null]);
        }

        $transaction->update($request->all());

        return redirect()->route('transaction.index')->with('success', 'Data transaksi diperbarui'); // Perbaiki: success
    }

    // DELETE: Hapus transaksi
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        // Jika menghapus data yang statusnya masih 'pinjam', kembalikan stoknya
        if ($transaction->status == 'pinjam') {
            $transaction->book->increment('stok'); // Perbaiki: increment bukan incrument
        }

        $transaction->delete();
        return redirect()->route('transaction.index')->with('success', 'Transaction dihapus'); // Perbaiki: route name
    }
}