<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. Buat Akun ADMIN
            User::create([
                'nama_lengkap' => 'Administrator Utama',
                'username'     => 'admin', // Login pakai ini
                'password'     => Hash::make('123456'), // Password: 123456
                'role'         => 'admin',
                'alamat'       => 'Ruang Admin Perpustakaan'
            ]);

        // 2. Buat Akun SISWA
        $siswa1 = User::create([
                'nama_lengkap' => 'Budi Santoso',
                'username'     => 'siswa', // Login pakai ini
                'password'     => Hash::make('123456'), // Password: 123456
                'role'         => 'siswa',
                'alamat'       => 'Jl. Mawar No. 10'
        ]);     

            User::create([
                'nama_lengkap' => 'Siti Aminah',
                'username'     => 'siti123',
                'password'     => Hash::make('123456'),
                'role'         => 'siswa',
                'alamat'       => 'Jl. Melati No. 5'
        ]);

        // 3. Buat Data BUKU Dummy
        $buku1 = Book::create([
            'judul'     => 'Belajar Laravel 10 untuk Pemula',
            'penulis'   => 'Taylor Otwell',
            'penerbit'  => 'Laravel Press',
            'kategori'  => 'Teknologi',
            'stok'      => 5
        ]);

        $buku2 = Book::create([
            'judul'     => 'Laskar Pelangi',
            'penulis'   => 'Andrea Hirata',
            'penerbit'  => 'Bentang Pustaka',
            'kategori'  => 'Novel',
            'stok'      => 3
    ]);

        $buku3 = Book::create([
            'judul'     => 'Filosofi Teras',
            'penulis'   => 'Henry Manampiring',
            'penerbit'  => 'Kompas',
            'kategori'  => 'Pengembangan Diri',
            'stok'      => 10
        ]);

        $buku4 = Book::create([
            'judul'     => 'Harry Potter dan Batu Bertuah',
            'penulis'   => 'J.K. Rowling',
            'penerbit'  => 'Gramedia',
            'kategori'  => 'Fiksi',
            'stok'      => 0 // Contoh stok habis
]);

     // 4. Buat Data TRANSAKSI Dummy (Contoh Riwayat)

        // Transaksi 1: Sedang Dipinjam
           Transaction::create([
             'user_id'        => $siswa1->id,
             'book_id'        => $buku1->id,
             'tanggal_pinjam' => Carbon::now()->subDays(2), // Pinjam 2 hari lalu
             'tanggal_kembali'=> null,
             'status'         => 'pinjam'
]);

// Kurangi stok buku 1 karena sedang dipinjam
        $buku1->decrement('stok');  

        // Transaksi 2: Sudah Dikembalikan
           Transaction::create([
             'user_id' => $siswa1->id,
             'book_id' => $buku2->id,
             'tanggal_pinjam' => Carbon::now()->subDays(10),
             'tanggal_kembali'=> Carbon::now()->subDays(3),
             'status' => 'kembali'
]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}