<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Department extends Model
{
    protected $table = 'tbl_department';
    protected $primaryKey = 'department_id';

    const CREATED_AT = 'department_created';
    const UPDATED_AT = 'department_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        "department_name",
    ];

    public static function get_record($search, $perpage)
    {
        $user = Auth::user();
        if ($user) {
            $department = Department::query()
                ->paginate($perpage);
            return $department;
        }
    }
}
