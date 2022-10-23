<?php

namespace Magnetism\Approval\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function approvableBodies()
    {
        return $this->hasMany(ApprovableBody::class);
    }

}
