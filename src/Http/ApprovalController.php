<?php

namespace Magnetism\Approval\Http;

use App\Http\Controllers\Controller;
use App\Models\User;
use Magnetism\Approval\Models\Approval;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Magnetism\Approval\Models\Approved;

class ApprovalController extends Controller {

    public function approvableSubjects(){

        try {
            $approvables               = config('approvalConfig');
            $approvables['users']      = User::all();

            return response()->json([
                'value' => $approvables,
                'message' => 'Approvables retrieved successfully.'
            ], 200);
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function index()
    {
        try {
            $approvables = Approval::with('approvalBodies')->latest()->get();

            return response()->json([
                'value' => $approvables,
                'message' => 'Approvables retrieved successfully.'
            ], 200);
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }


    public function store(Request $request)
    {
        try{
            DB::transaction(function () use ($request, &$approvable){
                $approvable = Approval::create(['model' => $request->model]);
                $approvable->approvalBodies()->createMany($request->approvalBodies);
            });
            return response()->json([
                'value' => $approvable,
                'message' => 'Approval added successfully.'
            ], 201);
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $approvable = Approval::with('approvalBodies')->find($id);
            return response()->json([
                'value' => $approvable,
                'message' => 'Approval retrieved successfully.'
            ], 200);
        } catch (\Exception $e)
        {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try{
            DB::transaction(function () use ($id, $request, &$approvable){
                $approvable = Approval::with('approvalBodies')->find($id);
                $approvable->update(['model' => $request->model]);
                $approvable->approvalBodies()->delete();
                $approvable->approvalBodies()->createMany($request->approvalBodies);
            });

            return response()->json([
                'value' => $approvable,
                'message' => 'Approval updated successfully.'
            ], 201);
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        try {
            Approval::find($id)->delete();
            return response()->json([
                'value' => '',
                'message' => 'Approval deleted successfully.'
            ], 204);
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function approved(Request $request)
    {
        try {
            $approvedData                      = $request->only('is_approved','remarks','approver_composite_key','approvable_id');
            $approvedData['approvable_type']   = base64_decode($request->approvable_type);
            $approvedData['approver_id']       = auth()->id();
            Approved::create($approvedData);
            return response()->json([
                'value' => $approvedData,
                'message' => 'Approved successfully.'
            ], 204);
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

}
