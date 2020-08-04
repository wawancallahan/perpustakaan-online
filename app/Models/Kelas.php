<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'name'
    ];

    public function scopeFilter($query, $request) {
        if ($request->has('q')) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->get('q') . '%');
            });
        }
    }
}
