<?php

namespace App\Models;

use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\CompanyUser;
use App\Models\Company;
use App\Models\UserType;
use App\Models\SettingState;

class User extends Authenticatable implements HasMedia
{
    use HasRoles, Notifiable, InteractsWithMedia;

    protected $table = 'tbl_user';
    protected $primaryKey = 'user_id';

    const CREATED_AT = 'user_created';
    const UPDATED_AT = 'user_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'username',
        'user_nric',
        'user_position',
        'user_fullname',
        'user_email',
        'dialcode_id',
        'user_mobile',
        'setting_dialcode_id',
        'password',
        'user_status',
        'user_type_id',
        'user_dob',
        'user_gender',
        'user_address',
        'user_address2',
        'user_city',
        'user_state_id',
        'user_postcode',
        'user_nationality',
        'user_logindate',
        'user_created',
        'user_updated',
        'is_deleted',
        'user_remember_token',
        'email_verified_at',
        'user_ip',
        'user_template_background_id',
        'user_template_banner_id',
        'user_template_colour',
        'user_facebook_url',
        'user_instagram_url',
    ];

    protected $hidden = [
        'password', 'user_remember_token'
    ];

    protected static function booted()
    {
        static::addGlobalScope("onlyNotDeleted", function (Builder $builder) {
            $builder->where("tbl_user.is_deleted", "=", 0);
        });
    }

    public function setting_state()
    {
        return $this->belongsTo(SettingState::class, 'user_state_id');
    }

    public function user_type()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }


    public function join_company()
    {
        return $this->hasOne(CompanyUser::class, 'user_id', 'user_id');
    }

    public function getEmailForPasswordReset()
    {
        return $this->user_email;
    }

    public function routeNotificationFor($driver)
    {
        if (method_exists($this, $method = 'routeNotificationFor' . Str::studly($driver))) {
            return $this->{$method}();
        }

        switch ($driver) {
            case 'database':
                return $this->notifications();
            case 'mail':
                return $this->user_email;
            case 'nexmo':
                return $this->user_mobile;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
    public function getRememberTokenName()
    {
        return 'user_remember_token';
    }

    public function getFullNameAttribute()
    {
        return ucwords($this->user_fullname);
    }

    public static function get_record($search, $perpage, $type = [], string $group_type = null, int $company_id = null, int $branch_id = null)
    {
        $user = User::query()
            ->when(!empty($search['freetext']), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('tbl_user.user_email', 'like', '%' . $search['freetext'] . '%')
                        ->orWhere('tbl_user.user_mobile', 'like', '%' . $search['freetext'] . '%')
                        ->orWhere('tbl_user.user_fullname', 'like', '%' . $search['freetext'] . '%')
                        ->orWhere('tbl_user.user_position', 'like', '%' . $search['freetext'] . '%')
                        ->orWhere('tbl_user.username', 'like', '%' . $search['freetext'] . '%');
                });
            })
            ->when(isset($search['user_status']), function ($query) use ($search) {
                $query->where('tbl_user.user_status', $search['user_status']);
            })
            ->when(isset($search['branch_id']), function ($query) use ($search) {
                $query->where('tbl_company_branch.company_branch_id', $search['branch_id']);
            })
            ->when(isset($search['company_id']), function ($query) use ($search) {
                $query->whereHas('join_company', function ($q) use ($search) {
                    $q->where('company_id', $search['company_id']);
                });
            })
            ->when(Auth::user()->roles->value('id') == 3, function (Builder $query) use ($company_id) {
                $query->whereHas('join_company', function ($q) use ($company_id) {
                    $q->where('company_id', $company_id);
                });
            })
            ->when(Auth::user()->roles->value('id') == 4 && Auth::user()->join_company->company_branch_id == null, function (Builder $query) use ($company_id) {
                $query->whereHas('join_company', function ($q) use ($company_id) {
                    $q->where('company_id', $company_id);
                });
            })
            ->when(Auth::user()->roles->value('id') == 4 && Auth::user()->join_company->company_branch_id != null, function (Builder $query) use ($branch_id) {
                $query->whereHas('join_company', function ($q) use ($branch_id) {
                    $q->where('company_branch_id', $branch_id);
                });
            })
            ->with('user_type')
            ->leftJoin('tbl_user_model_has_role as umhs', 'tbl_user.user_id', '=', 'umhs.model_id')
            ->leftJoin('tbl_user_role as ur', 'umhs.role_id', '=', 'ur.id')
            ->leftJoin('tbl_company_user', 'tbl_user.user_id', '=', 'tbl_company_user.user_id') // Join with tbl_company_user
            ->leftJoin('tbl_company_branch', 'tbl_company_user.company_branch_id', '=', 'tbl_company_branch.company_branch_id') // Join with tbl_company_branch
            ->when(isset($search['user_role_id']), function ($query) use ($search) {
                $query->where('umhs.role_id', $search['user_role_id']);
            })
            ->when($type, function ($query) use ($type) {
                $query->whereIn('tbl_user.user_type_id', $type);
            })
            ->where('tbl_user.is_deleted', 0)
            ->orderBy('tbl_user.user_updated', 'DESC')
            ->paginate($perpage, ['tbl_user.*', 'ur.name as user_role_name', 'tbl_company_branch.company_branch_name']);

        return $user;
    }

    public static function get_user_record($search, $perpage, $type = [])
    {
        $user = User::with('user_company', 'join_company.company');

        if (@$search['freetext']) {
            $freetext = $search['freetext'];
            $user->where(function ($q) use ($freetext) {
                $q->where('tbl_user.user_email', 'like', '%' . $freetext . '%')
                    ->orWhere('tbl_user.user_mobile', 'like', '%' . $freetext . '%')
                    ->orWhere('tbl_user.user_fullname', 'like', '%' . $freetext . '%');
            });
        }
        if (@$search['user_application_status_id']) {
            $user = $user->where('tbl_user.user_application_status_id', $search['user_application_status_id']);
        } else {
            $user = $user->where('tbl_user.user_application_status_id', 1);
        }
        if ($type) {
            $user->whereIn('user_type_id', $type);
        }
        $user->where('is_deleted', 0)->orderBy('user_cdate', 'DESC');
        return $user->paginate($perpage);
    }

    public static function get_user_record_dealer($search, $perpage, $type = [])
    {
        $user = User::with('user_company', 'join_company.company');

        if (@$search['freetext']) {
            $freetext = $search['freetext'];
            $user->where(function ($q) use ($freetext) {
                $q->where('tbl_user.user_email', 'like', '%' . $freetext . '%')
                    ->orWhere('tbl_user.user_mobile', 'like', '%' . $freetext . '%')
                    ->orWhere('tbl_user.user_fullname', 'like', '%' . $freetext . '%');
            });
        }
        if (@$search['user_application_status_id']) {
            $user = $user->where('tbl_user.user_application_status_id', $search['user_application_status_id']);

            // if (@$search['admin_user_id'] && !($$search['user_application_status_id'] == 1)) {
            // if (@$search['admin_user_id']) {

            //     $user->leftJoin('tbl_company_user as company_user', 'tbl_user.user_id', '=', 'company_user.user_id');
            //     $user->leftJoin('tbl_company as company', 'company_user.company_id', '=', 'company.company_id');

            //     $user->where('company.admin_user_id', $search['admin_user_id']);
            // }
            if (@$search['admin_user_id']) {
                $admin_user_id = $search['admin_user_id'];
                $user->whereHas('join_company', function ($q) use ($admin_user_id) {
                    $q->whereHas('company', function ($q) use ($admin_user_id) {
                        $q->where('admin_user_id', $admin_user_id);
                    });
                });
            }
        }
        if ($type) {
            $user->whereIn('user_type_id', $type);
        }
        // if (@$search['company_state']) {

        //     $user->leftJoin('tbl_company_user as company_user', 'tbl_user.user_id', '=', 'company_user.user_id');
        //     $user->leftJoin('tbl_company as company', 'company_user.company_id', '=', 'company.company_id');

        //     $user->where('company.company_state_id', $search['company_state']);
        // }
        if (@$search['company_state']) {

            $company_state_id = $search['company_state'];
            $user->whereHas('join_company', function ($q) use ($company_state_id) {
                $q->whereHas('company', function ($q) use ($company_state_id) {
                    $q->where('company_state_id', $company_state_id);
                });
            });
        }

        $users = Auth::user();
        $company = Company::where('admin_user_id', $users->user_id)->get('company_id');
        foreach ($company as $key => $value) {
            $user_under_admin[$key] = CompanyUser::where('company_id', $value->company_id)->get('user_id');
        }

        if ($users->can('company_verify_all')) {

            $result = $user->where('is_deleted', 0)->orderBy('user_cdate', 'DESC')->paginate($perpage);
        } elseif ($users->can('company_verify_assigned')) {
            if (@$user_under_admin) {
                $user_arr = [];

                foreach (@$user_under_admin as $value_1) {
                    foreach ($value_1 as $value_2) {
                        array_push($user_arr, $value_2->user_id);
                    }
                }

                $user->whereIn('user_id', $user_arr);
            }

            $result = $user->where('is_deleted', 0)->orderBy('user_cdate', 'DESC')->paginate($perpage);
        } else {

            $result = $user->where('is_deleted', 0)->orderBy('user_cdate', 'DESC')->paginate(); //return empty

        }

        return $result;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user_profile_photo_crop')
            ->singleFile();
        $this->addMediaCollection('user_profile_photo')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumbnail')
                    ->width(256)
                    ->height(256);
            });

        $this->addMediaCollection('user_ic')
            ->singleFile();
        $this->addMediaCollection('user_business_card')
            ->singleFile();
    }

    public static function get_sel_merchant(int $company_id = null)
    {
        $user = User::query()
            ->whereHas("user_type", function (Builder $query_user_type) {
                $query_user_type->where("user_type_group", "=", "user");
            })
            ->when(isset($company_id), function ($query) use ($company_id) {
                $query->whereHas('join_company', function ($q) use ($company_id) {
                    $q->where('company_id', $company_id);
                });
            })
            ->get()
            ->pluck('username', 'user_id')
            ->toArray();

        return ['' => 'Select User'] + $user;
    }

    public static function get_company_branch_user(int $company_id = null)
    {
        $user = User::query()
            ->selectRaw('CONCAT(tbl_user.username, " @ ", tbl_company_branch.company_branch_name) as company_branch_user')
            ->addSelect('tbl_user.user_id')
            ->leftJoin('tbl_company_user', 'tbl_user.user_id', '=', 'tbl_company_user.user_id')
            ->leftJoin('tbl_company_branch', 'tbl_company_user.company_branch_id', '=', 'tbl_company_branch.company_branch_id')
            ->whereHas("user_type", function (Builder $query_user_type) {
                $query_user_type->where("user_type_group", "=", "user");
            })
            ->when(isset($company_id), function ($query) use ($company_id) {
                $query->whereHas('join_company', function ($q) use ($company_id) {
                    $q->where('company_id', $company_id);
                });
            })
            ->orderBy('tbl_user.username')
            ->get()
            ->pluck('company_branch_user', 'user_id')
            ->toArray();

        return ['' => 'Select User'] + $user;
    }

    public function scopeEnsureActiveUsers(Builder $query): Builder
    {
        return $query
            ->where('user_status', '=', 'active')
            ->where('is_deleted', '=', 0);
    }
}
