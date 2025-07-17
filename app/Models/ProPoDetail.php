<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProPoDetail extends Model
{
    protected $table      = 'pro_po_detail';
    protected $primaryKey = 'id_pod';
    public    $incrementing = false;   // atau true jika auto‐increment
    protected $keyType      = 'string'; // atau 'int'

    protected $fillable = [
        'id_pod',
        'volume_po',
        // … kolom lain …
    ];

    /**
     * Relasi ke semua ds_detail yang pakai id_pod ini
     */
    public function dsDetails()
    {
        return $this->hasMany(ProPoDsDetail::class, 'id_pod', 'id_pod');
    }
}
