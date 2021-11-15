<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{
    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    public function transactions()
    {
        return $this->belongsTo(Transaction::class);
    }
}
