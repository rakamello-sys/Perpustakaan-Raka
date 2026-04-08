@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Edit Data Buku</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul" class="form-control @error('judul) is-invalid
    @enderror" value="{{ old('judul', $book->judul) }}" required>
                         @error('judul')
                         <div class="invalid-feedback"{{ $message }}</div>
                         @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control" @error('penulis') 
    is-invalid @enderror" value="{{ old('penulis', $book->penulis) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" class="form-control @error('penerbit')is-invalid @enderror" value="{{ old('penerbit', $book->penerbit) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $book->kategori) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control @error('stok')is-invalid
                        @enderror" value="{{ old('stok', $book->stok) }}" min="0" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('books.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection