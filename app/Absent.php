<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Absent extends Model
{
    //
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function create_absent($user)
    {
        $absent = Absent::where('id', '=', $user->id)
            ->whereDate('created_at', '=', Carbon::today())->first();
        if ($absent == null) {
            $absent = new Absent;
            $absent->user_id = $user->id;
            $absent->save();
            return $absent;
        }
    }
}
