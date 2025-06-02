<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentEquipment extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_department_equipment';
    protected $primaryKey = 'department_equipment_id';

    const CREATED_AT = 'department_equipment_created';
    const UPDATED_AT = 'department_equipment_updated';
    const DELETED_AT = 'deleted_at';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        "department_equipment_name",
        "department_id"
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }


    public static function get_record($search, $perpage, int $department_id)
    {
        $company_branch = DepartmentEquipment::query()
            ->where('department_id', '=', $department_id)
            ->when(!empty($search['keywords']), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('department_equipment_name', 'like', '%' . $search['keywords'] . '%');
                });
            })
            ->orderbyDesc('department_equipment_created')
            ->paginate($perpage);

        return $company_branch;
    }
}
