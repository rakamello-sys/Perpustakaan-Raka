@extends('layout')

@section('content')
<h1>Dashboard Admin</h1>
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Kelola Data Buku</div>
            <div class="card body">
                <p class="card-text">Tambah, Edit, Hapus data buku.</p>
                <a href="{{ route('books.index') }}" class="btn btn-light">Buka Menu</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Kelola Anggota</div>
            <div class="card-body">
                <p class="card-text">Manajemen data siswa.</p>
                <a href="{{ route('user.index') }}" class="btn btn-light">Buka Menu</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-header">Laporan Transaksi</div>
            <div class="card-body">
                <p class="card-text">Lihat riwayat peminjaman.</p>
                <a href="/admin/transaction" class="btn btn-light">Buka Menu</a>
            </div>
        </div>
    </div>
</div>
@endsection