<?php


namespace Magnetism\Approval\traits;

use App\Models\User;
use Magnetism\Approval\Models\Approval;
use Magnetism\Approval\Models\ApprovalBody;

trait MustBeApproved
{
    public function approvalProcess($model, $collections)
    {

        $approval = Approval::with('approvalBodies.approver')->where('model', $model)->first();
        $approvalOrders = $approval->approvalBodies->pluck('approver_composite_key', 'approver_composite_key'); // pluck->composite(); 

        $newCollections = $collections->map(function($item)use($approval, $approvalOrders){
            if($approvalOrders->count() == $item->approveds->count()){
                $item['approved_status'] = "Approved";
            }else{
                $approveds                      =  $item->approveds->pluck('approver_composite_key');
                $incompleteSteps                =  $approvalOrders->diff($approveds);
                $currentApprovers               =  $approval->approvalBodies->where('approver_composite_key', $incompleteSteps->first()); 
                $item['approved_status']        =  "Pending";
                $item['current_approver']       =  $currentApprovers->pluck('approver')->pluck('name')->join(' / '); 
                $item['get_approve_button']     =  $currentApprovers->contains('approver_id', auth()->id()) ? True : False;
                $item['approver_composite_key'] =  $currentApprovers->first()->approver_composite_key;
            }

            return $item;
        });

        return $newCollections;
    }
}