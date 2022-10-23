<?php


namespace Magnetism\Approval\traits;

use App\Models\User;
use Magnetism\Approval\Models\Approval;
use Magnetism\Approval\Models\ApprovalBody;

trait MustBeApproved
{
    public function approvalBodies($model, $collections)
    {

        $approval = Approval::with('approvableBodies')->where('model', $model)->first();
        $approvalBodies = $approval->approvableBodies;

        $newCollections = $collections->map(function($item)use($approvalBodies){
            if($approvalBodies->count() == $item->approveds->count()){
                $item['approved_status'] = "Approved";
            }else{
                $approveds                    = $item->approveds->pluck('approver_composite_key');
                $upcomingApprovers            = $approvalBodies->diff(ApprovalBody::whereIn('approver_composite_key', [count($approveds) > 0 ? $approveds : null])->get());
                $currentApprover              = User::find($upcomingApprovers->first->approver_id->approver_id);
                $item['approved_status']      = "Pending";
                $item['current_approver']     = $currentApprover->name;
                $item['get_approve_button']   = auth()->id() == $currentApprover->id ? True : False;
            }
            return $item;
        });
        return $newCollections;
    }
}