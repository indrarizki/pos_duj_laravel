<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AbsentCust extends Model
{
    protected $table = "logs";
    protected $primaryKey = 'id'; // or null
    // protected $fillable = ["id","log_time","name","data"];
    // public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    // protected $keyType = 'string';
    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }
    public static function get_all_absents()
    {
        $absentcusts = AbsentCust::with('customers');
        
        return $absentcusts;
    }

    public static function get_absents($id)
    {
        $absent = AbsentCust::where('id', '=', $id)
            ->with('customers')
            ->first();

        return $absent;
    }

    public static function search($request)
    {
        $where_query = [];
        // $id = $request->id;
        $sort_type = $request->sort_type ?? "desc";
        $date_time = $request->date_time ?? null;
        $absentcusts = AbsentCust::where($where_query);
        if ($date_time != null) {
            $where_query['date_time'] = $date_time;
            $absentcusts = $absentcusts->whereDate('log_time', '=', $where_query['date_time']);
        }
        $absentcusts = $absentcusts
            ->with('customers')
            ->orderBy('log_time', $sort_type)
            ->paginate(100);

        $data = [];
        $data['absentcusts'] = $absentcusts;
        $data['where_query'] = $where_query;
        $data['sort_type'] = $sort_type;
        return $data;
    }
}