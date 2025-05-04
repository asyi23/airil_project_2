<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;

class UserType extends Model
{
    protected $table = 'tbl_user_type';
    protected $primaryKey = 'user_type_id';

    public static function get_user_type()
    {
        $user_type = UserType::get();
        return $user_type;
    }

    public static function get_user_type_sel_without_admin()
    {
        $user_type = UserType::whereNotIn('user_type_id', [1,5,6])->get();
//        $temp[''] = 'Please select type';
        foreach ($user_type as $type) {
            $temp[$type->user_type_id] = $type->user_type_name;
        }
        return $temp;
    }
    public static function get_user_type_without_admin_sel()
    {
        $user_type = UserType::where('user_type_id', '!=', 1)->get();
        $temp[''] = 'Please select User type';
        foreach ($user_type as $type) {
            $temp[$type->user_type_id] = $type->user_type_name;
        }
        return $temp;
    }

    public static function get_user_type_sel()
    {
        $user_type = UserType::query()->whereIn('user_type_slug',['dealer-agent','dealer'])->get();
        $temp[''] = 'Please select type';
        foreach ($user_type as $type) {
            $temp[$type->user_type_id] = $type->user_type_name;
        }
        return $temp;
    }
    public static function get_user_type_sel_company()
    {
        $user_type = UserType::whereIn('user_type_id', [2,4])->get();
        $temp[''] = 'Please select user type';
        foreach ($user_type as $type) {
            $temp[$type->user_type_id] = $type->user_type_name;
        }
        return $temp;
    }

    public static function get_user_type_lead_sel_company()
    {
        $user_type = UserType::whereIn('user_type_id', [2,3,4])
        ->get()
        ->pluck('user_type_name','user_type_id')
        ->toArray();
        return ['' => 'Please select user type'] + $user_type;
    }

    public static function get_user_role_sel(string $user_type_group = null)
    {
        $user_role = Role::query()
            ->when(!empty($user_type_group), function (Builder $query_user_type_group) use ($user_type_group) {
                $query_user_type_group->where('user_type_group', '=', $user_type_group);
            })
            ->get();
        foreach ($user_role as $role) {
            $temp[$role->id] = $role->name;
        }
        return $temp;
    }

    public static function get_admin_user_type()
    {
        $user_type = UserType::where('user_type_group', 'Administrator')
            ->get();

        return $user_type->pluck('user_type_name', 'user_type_id')->toArray();
    }

    public static function get_all_user_type_sel()
    {
        $user_type = UserType::where('user_type_group', '!=', 'Administrator')
            ->get();

        return $user_type->pluck('user_type_name', 'user_type_id')->toArray();
    }
}
