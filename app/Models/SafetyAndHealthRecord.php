<?php

namespace App\Models;

use App\Models\SafetyAndHealth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class SafetyAndHealthRecord extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_safety_and_health_record';
    protected $primaryKey = 'safety_and_health_record_id';

    const CREATED_AT = null;
    const UPDATED_AT = null;
    const DELETED_AT = 'deleted_at';


    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        "safety_and_health_id",
        "safety_and_health_record_id",
        "safety_and_health_record_name",
    ];


    public function safety_and_health()
    {
        return $this->belongsTo(SafetyAndHealth::class, 'safety_and_health_id');
    }

    public static function get_record($search, $perpage, $id)
    {
        $user = Auth::user();
        if ($user) {
            $safety_health = SafetyAndHealthRecord::query()
                ->where("safety_and_health_id", $id)
                ->paginate($perpage);
            return $safety_health;
        }
    }
}
