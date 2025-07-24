<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\User;
use App\Models\Vendor;
use App\Models\AssetAssignment;
use Illuminate\Support\Facades\Validator;

class AdminController
{
    public function dashboard()
    {
        $stats = [
            'total_assets' => Asset::count(),
            'assigned_assets' => Asset::where('status', 'Assigned')->count(),
            'unassigned_assets' => Asset::where('status', 'Unassigned')->count(),
            'returned_assets' => Asset::where('status', 'Returned to vendor')->count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_vendors' => Vendor::count(),
        ];

        // Load all asset assignments with asset & user info
        $assignments = AssetAssignment::with(['asset', 'user'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.dashboard', compact('stats', 'assignments'));
    }


    // Add asset
    public function createAsset()
    {
        $vendors = Vendor::all();
        return view('admin.assets.create', compact('vendors'));
    }

    public function storeAsset(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'specification' => 'required|string',
            'nrg_serial_number' => 'required|string|unique:assets,nrg_serial_number',
            'category' => 'required|in:Laptop,Monitor,Mouse,Keyboard,Others',
            'handling_type' => 'required|in:Returnable,Non-returnable,Consumable',
            'vendor_id' => 'required|exists:vendors,id',
            'procurement_date' => 'required|date',
            'status' => 'required|in:Unassigned,Assigned,Returned to vendor',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        Asset::create($validator->validated());

        return redirect()->route('admin.dashboard')->with('success', 'Asset created successfully.');
    }

    // Add Vendor
    public function createVendor(){
        return view('admin.vendors.create');
    }

    public function storeVendor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:vendors,name',
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Vendor::create($validator->validated());

        return redirect()->route('admin.dashboard')->with('success', 'Vendor created successfully.');
    }

    // Assign Asset
    public function createAssignment(){
        $users = User::where('role', 'user')->get();
        $assets = Asset::doesntHave('assignments')->get();
        return view('admin.assignments.create', compact('users', 'assets'));
    }

    public function storeAssignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asset_id' => 'required|exists:assets,id',
            'user_id' => 'required|exists:users,id',
            'assigned_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        AssetAssignment::create($validator->validated());

        return redirect()->route('admin.dashboard')->with('success', 'Asset assigned successfully.');
    }

    public function returnAsset($id)
{
    $assignment = AssetAssignment::where('asset_id', $id)->where('returned', false)->first();

    if ($assignment) {
        $assignment->update([
            'returned' => true,
            'returned_at' => now()
        ]);

        $asset = Asset::find($id);
        $asset->update([
            'status' => 'Returned to vendor',
            'returned_date' => now()
        ]);

        return back()->with('success', 'Asset marked as returned successfully.');
    }

    return back()->with('error', 'Asset assignment not found or already returned.');
}
}
