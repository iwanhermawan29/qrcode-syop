<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProPoDs extends Model
{
    protected $table      = 'pro_po_ds';
    protected $primaryKey = 'id_ds';
    public    $incrementing = false;
    protected $keyType      = 'string';

    // … cast, fillable, dates dsb …

    /**
     * Semua baris detail yang terkait dengan header ini
     */
    public function details()
    {
        // hasMany(RelatedModel, foreign_key_on_related, local_key)
        return $this->hasMany(ProPoDsDetail::class, 'id_ds', 'id_ds');
    }
}
