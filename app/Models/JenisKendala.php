<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKendala extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kendala',
    ];
}
