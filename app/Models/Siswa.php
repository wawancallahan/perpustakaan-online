<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'name',
        'generation',
        'class',
        'gender',
        'phone',
        'address',
        'status',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusFormattedAttribute() {
        switch ($this->status) {
            case 0:
                return '<span class="badge badge-warning">Menunggu Validasi</span>';
            case 1:
                return '<span class="badge badge-success">Tervalidasi</span>';
        }
    }

    public function getGenderFormattedAttribute() {
        switch ($this->gender) {
            case 'L':
                return 'Laki-Laki';
            case 'P':
                return 'Perempuan';
        }

        return '-';
    }
}
