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

    public function scopeOnThisSiswa($query)
    {
        return $query->where('siswa_id', auth()->user()->siswa->id);
    }

    public function scopeFilter($query, $request) {
        if ($request->has('q')) {
            $query->where(function ($query) use ($request) {
                $query->where('tanggal_pinjam', 'LIKE', '%' . $request->get('q') . '%')
                    ->orWhere('tanggal_kembali', 'LIKE', '%' . $request->get('q') . '%')
                    ->orWhere(function ($query) use ($request) {
                        $query->orWhereHas('book', function ($query) use ($request) {
                            $query->where('judul', 'LIKE', '%' . $request->get('q') . '%');
                        });
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->orWhereHas('siswa', function ($query) use ($request) {
                            $query->where('nis', 'LIKE', '%' . $request->get('q') . '%')
                                ->orWhere('name', 'LIKE', '%' . $request->get('q') . '%');
                        });
                    });
            });
        }
    }

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
        return $this->tanggal_pinjam->format('Y-m-d');
    }

    public function getTanggalKembaliFormattedAttribute()
    {
        return $this->tanggal_kembali->format('Y-m-d');
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
