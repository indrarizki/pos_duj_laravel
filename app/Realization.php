<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Realization extends Model
{
    protected $primaryKey = 'id'; // or null

    public $incrementing = false;
    protected $keyType = 'string';
    
    public function budgetings()
    {
        return $this->belongsTo(Budgeting::class, 'budgeting_id');
    }
    public static function get_all_realization()
    {
        $realization = Realization::with('budgetings');
        
        return $realization;
    }
}
