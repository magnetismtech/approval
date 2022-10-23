<?php

namespace Magnetism\Approval\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalBody extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($approvalBody) {
            $approvalBody['approver_composite_key'] = "M$approvalBody->approval_id"."_A$approvalBody->approver_id"."_O$approvalBody->approval_order";
        });
    }
}
