<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class SafetyAndHealth extends Model
{
    protected $table = 'tbl_safety_and_health';
    protected $primaryKey = 'safety_and_health_id';

    const CREATED_AT = null;
    const UPDATED_AT = null;
    const DELETED_AT = null;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        "safety_and_health_id",
        "safety_and_health_name",
    ];


    public static function get_record($search, $perpage)
    {
        $user = Auth::user();
        if ($user) {
            $safety_health = SafetyAndHealth::query()
                ->paginate($perpage);
            return $safety_health;
        }
    }
}
