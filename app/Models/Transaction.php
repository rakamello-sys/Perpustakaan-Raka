<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'book_id', 'tanggal_pinjam', 'tanggal_kembali', 'status'];

    public function user() {return $this->belongsTo(User::class);}
    public function book() {return $this->belongsTo(Book::class);}
    //
}
