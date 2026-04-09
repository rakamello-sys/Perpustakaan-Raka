@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Kelola Transaksi</h2>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
        Tambah Peminjaman Manual
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trans)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $trans->user->nama_lengkap }}</td>
                    <td>{{ $trans->book->judul }}</td>
                    <td>{{ $trans->tanggal_pinjam }}</td>
                    <td>
                        <span class="badge {{ $trans->status == 'pinjam' ? 'bg-warning' : 'bg-success' }}">
                            {{ ucfirst($trans->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('transactions.edit', $trans->id) }}" class="btn btn-sm btn-info">
                            Edit
                        </a>

                        <form action="{{ route('transactions.destroy', $trans->id) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Hapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection