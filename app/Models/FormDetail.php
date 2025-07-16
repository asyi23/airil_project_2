<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormDetail extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_form_detail';
    protected $primaryKey = 'form_detail_id';

    const CREATED_AT = 'form_detail_created';
    const UPDATED_AT = 'form_detail_updated';
    const DELETED_AT = 'deleted_at';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        "form_detail_date",
        "form_detail_order_no",
        "form_detail_quantity",
        "form_detail_done_by",
        "form_detail_remark",
        "form_detail_oum",
        "form_id",
        "form_detail_end_date",
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public static function get_record($search, $perpage, $id)
    {
        $user = Auth::user();
        if ($user) {
            $form_detail = FormDetail::query()
                ->when(!empty($search['start_date']) && !empty($search['end_date']), function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->whereBetween('form_detail_date', [$search['start_date'], $search['end_date']]);
                    });
                })
                ->when(!empty($search['keywords']), function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('form_detail_order_no', 'like', '%' . $search['keywords'] . '%');
                    });
                })

                ->where("form_id", $id)
                ->orderBy("form_detail_end_date", "asc")
                ->paginate($perpage);
            return $form_detail;
        }
    }

    public static function get_record_delete($search, $perpage, $id)
    {
        $user = Auth::user();
        if ($user) {
            $form_detail = FormDetail::onlyTrashed()
                ->where('form_id', $id)
                ->paginate($perpage);
            return $form_detail;
        }
    }

    public static function get_record_quantity($search, $perpage, $id)
    {
        $form_detail_quantity = FormDetail::query()
            ->when(!empty($search['start_date']) && !empty($search['end_date']), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereBetween('form_detail_date', [$search['start_date'], $search['end_date']]);
                });
            })
            ->when(!empty($search['start_date']) && !empty($search['end_date']), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereBetween('form_detail_date', [$search['start_date'], $search['end_date']]);
                });
            })
            ->where("form_id", $id)
            ->sum('form_detail_quantity');
        return $form_detail_quantity;
    }
}
