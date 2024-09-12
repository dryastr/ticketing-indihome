<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik_id',
        'pelanggan_id',
        'jenis_kendala_id',
        'STO',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nik_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function jenisKendala()
    {
        return $this->belongsTo(JenisKendala::class, 'jenis_kendala_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }
}
