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
        'kelas_id',
        'gender',
        'phone',
        'address',
        'status',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas() {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function scopeIsActive($query) {
        $query->where('status', 1);
    }

    public function scopeFilter($query, $request) {
        if ($request->has('q')) {
            $query->where(function ($query) use ($request) {
                $query->where('nis', 'LIKE', '%' . $request->get('q') . '%')
                    ->orWhere('name', 'LIKE', '%' . $request->get('q') . '%')
                    ->orWhere('phone', 'LIKE', '%' . $request->get('q') . '%')
                    ->orWhere('address', 'LIKE', '%' . $request->get('q') . '%')
                    ->orWhereHas('kelas', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->get('q') . '%');
                    });
            });
        }
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
