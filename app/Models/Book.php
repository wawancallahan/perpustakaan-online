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

    public function scopeFilter($query, $request) {
        
        if ($request->has('q')) {
            $query->where(function ($query) use ($request) {
                $query->where('isbn', 'LIKE', '%' . $request->get('q') . '%')
                    ->orWhere('judul', 'LIKE', '%' . $request->get('q') . '%')
                    ->orWhere('tahun', 'LIKE', '%' . $request->get('q') . '%')
                    ->orWhere('pengarang', 'LIKE', '%' . $request->get('q') . '%')
                    ->orWhere('penerbit', 'LIKE', '%' . $request->get('q') . '%');
            });
        }
    }

    public function scopeIsActive($query) {
        return $query->where('active', 1);
    }
}
