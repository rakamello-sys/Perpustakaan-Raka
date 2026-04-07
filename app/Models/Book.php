<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['judul', 'penulis', 'penerbit', 'kategori', 'stok'];

    public function transaction () {
        return $this->hashMany(Transaction::class);
    }
    //
}
