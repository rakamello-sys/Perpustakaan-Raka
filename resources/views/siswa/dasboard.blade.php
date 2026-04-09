@extends('layout')

@section('content')
<h1>Dashboard Siswa</h1>

<div class="row mt-4">

    <!-- Peminjaman Buku -->
    <div class="col-md-6">
        <div class="card">

            <div class="card-header bg-primary text-white">
                <h4>Peminjaman Buku</h4>
            </div>

            <div class="card-body">
                <h5>Daftar Buku Tersedia</h5>

                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                        <tr>
                            <td>{{ $book->judul }}</td>
                            <td>{{ $book->stok }}</td>
                            <td>
                                @if($book->stok > 0)
                                    <form action="/siswa/pinjam/{{ $book->id }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-primary">
                                            Pinjam
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Pengembalian Buku -->
    <div class="col-md-6">
        <div class="card">

            <div class="card-header bg-success text-white">
                <h4>Pengembalian Buku</h4>
            </div>

            <div class="card-body">
                <h5>Buku yang sedang dipinjam</h5>

                @if($myBooks->isEmpty())
                    <p class="text-muted">
                        Tidak ada buku yang sedang dipinjam.
                    </p>
                @else
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tgl Pinjam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($myBooks as $trans)
                            <tr>
                                <td>{{ $trans->book->judul }}</td>
                                <td>{{ $trans->tanggal_pinjam }}</td>
                                <td>
                                    <form action="/siswa/kembali/{{ $trans->id }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-warning">
                                            Kembalikan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>

</div>
@endsection