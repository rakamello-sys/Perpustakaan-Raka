<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //Digunakan untuk Dashboard & Monitoring
    public function index() {
        $totalBuku = Book::count();
        $totalSiswa = User::where('role', 'siswa')->count();
        return view('admin.dasboard', compact('totalBuku', 'totalSiswa'));
    }
}
