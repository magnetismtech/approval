<?php

namespace Magnetism\Approval\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approved extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function approvable()
    {
        return $this->morphTo();
    }
}
