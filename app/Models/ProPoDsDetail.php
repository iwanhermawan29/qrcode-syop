<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProPoDetail;

class ProPoDsDetail extends Model
{
    protected $table      = 'pro_po_ds_detail';
    protected $primaryKey = 'id';          // sesuaikan jika primary key Anda berbeda
    public    $incrementing = true;        // atau false, tergantung
    protected $keyType      = 'int';       // atau 'string'

    protected $fillable = [
        'id_ds',
        'sold_to',
        'product_name',
        'quantity',
        'unit_price',
        // … kolom lain …
    ];

    /**
     * Kembali ke header PO (ProPoDs)
     */
    public function po()
    {
        return $this->belongsTo(ProPoDs::class, 'id_ds', 'id_ds');
    }

    public function poDetail()
    {
        return $this->belongsTo(ProPoDetail::class, 'id_pod', 'id_pod');
    }

    /**
     * Optional: override atribut qty supaya langsung ambil volume_po
     */
    public function getQtyAttribute(): ?float
    {
        return $this->poDetail->volume_po ?? null;
    }
}
