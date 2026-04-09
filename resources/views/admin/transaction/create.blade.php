@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            
            <div class="card-header bg-primary text-white">
                Tambah Peminjaman (Admin)
            </div>

            <div class="card-body">
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Nama Siswa</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->nama_lengkap }} ({{ $user->username }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Judul Buku</label>
                        <select name="book_id" class="form-select" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">
                                    {{ $book->judul }} (Stok: {{ $book->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" 
                               class="form-control" 
                               value="{{ date('Y-m-d') }}" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Status Awal</label>
                        <select name="status" class="form-select">
                            <option value="pinjam">Sedang Dipinjam</option>
                            <option value="kembali">Langsung Dikembalikan</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">
                        Simpan Transaksi
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                        Batal
                    </a>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection