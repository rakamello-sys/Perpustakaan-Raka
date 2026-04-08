@extends('layout')

@section('content')
<div class="row justify-content-center">
<div class="col-md-4">
    <div class="card=header text-center">
        <h3>Login Perpustakaan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="Password" name="Password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <p>Belum punya akun?</p>
                            <a href="/register" class="btn btn-outline-secondary w-100">Daftar Anggota</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection