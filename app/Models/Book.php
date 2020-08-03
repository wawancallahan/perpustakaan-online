<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'isbn',
        'judul',
        'tahun',
        'pengarang',
        'penerbit',
        'active',
        'created_by'
    ];

    public function scopeIsActive($query) {
        return $query->where('active', 1);
    }
}
