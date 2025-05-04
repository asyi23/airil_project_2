<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class UserRole extends Model
{
    protected $table = 'tbl_user_role';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'name', 'guard_name'
    ];

    public static function get_record($search, $perpage = null)
    {
        $query = UserRole::query();

        if (@$search['keyword']) {
            $keyword = $search['keyword'];
            $query->where(function ($q) use ($keyword) {
                $q->where('tbl_user_role.name', 'like', '%' . $keyword . '%');
            });
        }

        $query->orderBy('name');

        if($perpage > 0){
            $result = $query->paginate($perpage);
        } else {
            $result = $query->get();
        }

        return $result;
    }

    public static function get_by_id($id)
    {
        $query = UserRole::query();
        return $query->where('id', $id)->first();
    }

    public static function get_sel(){
        $query = Role::query()
                ->orderby('name', 'asc')
                ->get()
                ->pluck('name', 'id')
                ->toArray();

        return ['' => 'Select User Role'] + $query;
    }

    public function getTotalUserAttribute()
    {
        return User::role($this->name)->count();
    }
}
