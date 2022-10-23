<?php

namespace Magnetism\Approval\Http;

use App\Http\Controllers\Controller;
use Magnetism\Approval\Models\Approvable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Magnetism\Approval\Models\Approved;

class ApprovableController extends Controller {

    public function index()
    {
        try {
            $approvables = Approvable::with('approvableBodies')->latest()->get();

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
                $approvable = Approvable::create(['model' => $request->model]);
                $approvable->approvableBodies()->createMany($request->approvalBodies);
            });
            return response()->json([
                'value' => $approvable,
                'message' => 'Approvable added successfully.'
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
            $approvable = Approvable::with('approvableBodies')->find($id);
            return response()->json([
                'value' => $approvable,
                'message' => 'Approvable retrieved successfully.'
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
                $approvable = Approvable::with('approvableBodies')->find($id);
                $approvable->update(['model' => $request->model]);
                $approvable->approvableBodies()->delete();
                $approvable->approvableBodies()->createMany($request->approvalBodies);
            });

            return response()->json([
                'value' => $approvable,
                'message' => 'Approvable updated successfully.'
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
            Approvable::find($id)->delete();
            return response()->json([
                'value' => '',
                'message' => 'Approvable deleted successfully.'
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
            Approved::create($request->all());
            return response()->json([
                'value' => '',
                'message' => 'Approved successfully.'
            ], 204);
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }


}
