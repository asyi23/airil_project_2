<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Form extends Model
{
    protected $table = 'tbl_form';
    protected $primaryKey = 'form_id';

    const CREATED_AT = 'form_created';
    const UPDATED_AT = 'form_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        "form_name",
        "department_equipment_id",
    ];

    public function department_equipment()
    {
        return $this->belongsTo(DepartmentEquipment::class, 'department_equipment_id');
    }


    public static function get_record($search, $perpage, $id)
    {
        $user = Auth::user();
        if ($user) {
            $department = Form::query()
                ->where("department_equipment_id", $id)
                ->when(!empty($search['keywords']), function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('form_name', 'like', '%' . $search['keywords'] . '%');
                    });
                })
                ->paginate($perpage);
            return $department;
        }
    }
}
