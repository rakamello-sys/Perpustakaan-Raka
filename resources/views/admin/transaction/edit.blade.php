@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">

            <div class="card-header bg-warning">
                Edit Status Transaksi
            </div>

            <div class="card-body">
                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Peminjam</label>
                        <input type="text" class="form-control"
                               value="{{ $transaction->user->nama_lengkap }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Buku</label>
                        <input type="text" class="form-control"
                               value="{{ $transaction->book->judul }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam"
                               class="form-control"
                               value="{{ $transaction->tanggal_pinjam }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="pinjam"
                                {{ $transaction->status == 'pinjam' ? 'selected' : '' }}>
                                Sedang Dipinjam
                            </option>
                            <option value="kembali"
                                {{ $transaction->status == 'kembali' ? 'selected' : '' }}>
                                Sudah Dikembalikan
                            </option>
                        </select>
                        <small class="text-muted">
                            *Mengubah status ke 'Kembali' akan menambah stok buku.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Update
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