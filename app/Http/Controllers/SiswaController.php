<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Transaction; // Perbaiki: ini harus Transaction, bukan Book\transaction
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller // Perbaiki: hapus titik koma (;) setelah Controller
{
    public function index(){
        // Fitur Pencarian & List Buku
        $books = Book::all(); // Perbaiki: book::all() → Book::all() (kapital B)
        
        // List buku yang sedang dipinjam user ini
        $myBooks = Transaction::where('user_id', Auth::id())
                              ->where('status', 'pinjam')
                              ->get();
        
        return view('siswa.dashboard', compact('books', 'myBooks')); // Perbaiki: dasboard → dashboard
    }

    public function pinjamBuku($book_id) {
        $book = Book::findOrFail($book_id);

        // Logika kurangi stok
        if($book->stok > 0){ // Perbaiki: $book-> >0 → $book->stok > 0
            Transaction::create([
                'user_id' => Auth::id(),
                'book_id' => $book_id,
                'tanggal_pinjam' => Carbon::now(),
                'status' => 'pinjam',
                'tanggal_kembali' => null // Tambahkan field tanggal_kembali (bisa null)
            ]);

            $book->decrement('stok');
            return back()->with('success', 'Buku berhasil dipinjam');
        }
        return back()->with('error', 'Stok habis!');
    }
    
    public function kembalikanBuku($transaction_id) {
        $transaksi = Transaction::where('id', $transaction_id)
                                ->where('user_id', Auth::id()) // Validasi punya sendiri
                                ->firstOrFail();

        $transaksi->update([
            'tanggal_kembali' => Carbon::now(),
            'status' => 'kembali'
        ]);

        // Kembalikan stok buku
        $transaksi->book->increment('stok');

        return back()->with('success', 'Buku berhasil dikembalikan'); // Perbaiki: spasi setelah koma
    }
} 