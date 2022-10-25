<?php

namespace Magnetism\Approval\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalBody extends Model
{
    use HasFactory;
    protected $fillable = ['approval_id','approver_id','approval_order','approver_role', 'approver_composite_key'];

    protected static function booted()
    {
        static::creating(function ($approvalBody) {
            $approvalBody['approver_composite_key'] = "M$approvalBody->approval_id"."_A$approvalBody->approver_id"."_O$approvalBody->approval_order";
        });
    }

    public function approver()
    {
        return $this->belongsTo(User::class,'approver_id');
    }
}
