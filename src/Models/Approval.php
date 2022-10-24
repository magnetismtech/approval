<?php

namespace Magnetism\Approval\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function approvalBodies()
    {
        return $this->hasMany(ApprovalBody::class)->orderBy('approval_order', 'ASC');
    }

}
