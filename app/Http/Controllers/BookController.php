<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){
        $books = Book::all();
        return view('admin.book.index', compact('books'));
    }

    public function create(){
        return view('admin.books.create');
    }

    public function store(Request $request){
        // Validasi data buku
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'stok' => 'required|integer'
        ]);

        \App\Models\Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');

    }

    public function update(Request $request, $id){
        $book = \App\Models\Book::findOrFail($id);
        $book->update($request->all());
        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui');

    }

    public function destroy($id){
        \App\Models\Book::findOrFail($id)->delete();
        return redirect()->route('books.index')->with('success', 'Buku dihapus');
        
    }
    //
}
