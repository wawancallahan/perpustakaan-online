<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $dates = [
        'tanggal_pinjam',
        'tanggal_kembali'
    ];

    protected $fillable = [
        'tanggal_pinjam',
        'tanggal_kembali',
        'book_id',
        'siswa_id',
        'status'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function getTanggalPinjamFormattedAttribute()
    {
        return $this->tanggal_pinjam->format('Y-m-d H:i:s');
    }

    public function getTanggalKembaliFormattedAttribute()
    {
        return $this->tanggal_kembali->format('Y-m-d H:i:s');
    }

    public function getStatusFormattedAttribute()
    {
        switch ($this->status) {
            case 0:
                return '<span class="badge badge-info">Dalam Peminjaman</span>';
            case 1:
                return '<span class="badge badge-success">Telah Kembali</span>';
        }

        return '-';
    }
}
