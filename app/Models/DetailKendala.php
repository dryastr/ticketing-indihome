<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKendala extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_kendala_id',
        'detail_kendala',
    ];

    public function jenisKendala()
    {
        return $this->belongsTo(JenisKendala::class);
    }
}
