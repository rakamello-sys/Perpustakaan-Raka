@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-item-center mb-3">
    <h2>Kelola Anggota</h2>
    <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah Anggota</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop-iteration }}</td>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->alamat ?? '-' }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class=" btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST class=d-inline" onsubmit="return confirm('Yakin ingin menhapus anggota ini? Semua data peminjaman terkait juga akan terhapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data anggota.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
@endsection