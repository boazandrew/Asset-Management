<?php

namespace App\Http\Controllers;

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
            'total_assets'     => Asset::count(),
            'assigned_assets'  => Asset::where('status', 'Assigned')->count(),
            'unassigned_assets'=> Asset::where('status', 'Unassigned')->count(),
            'returned_assets'  => Asset::where('status', 'Returned to vendor')->count(),
            'total_users'      => User::where('role', 'user')->count(),
            'total_vendors'    => Vendor::count(),
        ];

        // Load all asset assignments with asset & user info
        $assignments = AssetAssignment::with(['asset', 'user'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.dashboard', compact('stats', 'assignments'));
    }

    // Add asset
    public function createAsset(Request $request)
    {
        $vendors = Vendor::all();

        // If AJAX request, return only the _form partial HTML
        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('admin.assets._form', compact('vendors'))->render();
        }

        // Normal full page (fallback)
        return view('admin.assets.create', compact('vendors'));
    }

    public function storeAsset(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'specification' => 'required|string',
            'category' => 'required|in:Laptop,Monitor,Mouse,Keyboard,Others',
            'handling_type' => 'required|in:Returnable,Non-returnable,Consumable',
            'vendor_id' => 'required|exists:vendors,id',
            'procurement_date' => 'required|date',
            // we don't require status on create — default to Unassigned
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['status'] = 'Unassigned';

        Asset::create($data);

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

        // Only assets that are currently unassigned should be selectable
        $assets = Asset::where('status', 'Unassigned')->get();

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

        $data = $validator->validated();

        $asset = Asset::findOrFail($data['asset_id']);
        if ($asset->status !== 'Unassigned') {
            return back()->with('error', 'This asset is not available for assignment.');
        }

        AssetAssignment::create($data);

        // mark asset as assigned
        $asset->status = 'Assigned';
        $asset->save();

        return redirect()->route('admin.dashboard')->with('success', 'Asset assigned successfully.');
    }

    /**
     * Return action from user -> mark assignment returned and make asset available (Unassigned)
     * $id is asset id (keeps your earlier route)
     */
    public function returnAsset($id)
    {
        $assignment = AssetAssignment::where('asset_id', $id)
                        ->where('returned', false)
                        ->latest()
                        ->first();

        if ($assignment) {
            $assignment->update([
                'returned' => true,
                'returned_at' => now(),
            ]);

            $asset = Asset::findOrFail($id);
            $asset->status = 'Unassigned';     // make available again
            $asset->returned_date = null;      // not "returned to vendor"
            $asset->save();

            return back()->with('success', 'Asset marked as returned (from user) and is now unassigned.');
        }

        return back()->with('error', 'Active assignment not found or already returned.');
    }

    /**
     * Mark asset as returned to vendor (admin action).
     * This closes any active assignment and sets asset status so it is not assignable anymore.
     */
    public function returnToVendor($id)
    {
        $asset = Asset::findOrFail($id);

        // close any active assignment
        $assignment = AssetAssignment::where('asset_id', $id)
                        ->where('returned', false)
                        ->latest()
                        ->first();

        if ($assignment) {
            $assignment->update([
                'returned' => true,
                'returned_at' => now(),
            ]);
        }

        $asset->status = 'Returned to vendor';
        $asset->returned_date = now();
        $asset->save();

        return back()->with('success', 'Asset marked as returned to vendor.');
    }

    // Edit Asset
    public function editAsset($id, Request $request)
    {
        $asset = Asset::findOrFail($id);
        $vendors = Vendor::all();

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('admin.assets._form', compact('asset', 'vendors'))->render();
        }

        return view('admin.assets.edit', compact('asset', 'vendors'));
    }

    // Update Asset
    public function updateAsset(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        // if asset is already returned to vendor, disallow edits to protect that asset
        if ($asset->status === 'Returned to vendor') {
            return back()->with('error', 'Cannot edit an asset that has been returned to vendor.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'specification' => 'required|string',
            'category' => 'required|in:Laptop,Monitor,Mouse,Keyboard,Others',
            'handling_type' => 'required|in:Returnable,Non-returnable,Consumable',
            'vendor_id' => 'required|exists:vendors,id',
            'procurement_date' => 'required|date',
            'status' => 'required|in:Unassigned,Assigned,Returned to vendor',
        ]);

        // If asset is currently assigned, do not allow changing status away from Assigned
        if ($asset->status === 'Assigned' && $validated['status'] !== 'Assigned') {
            return back()->with('error', 'Cannot change status while asset is assigned to a user.');
        }

        // Update normally
        $asset->update($validated);
        return redirect()->route('admin.dashboard')->with('success', 'Asset updated successfully.');
    }

    // Delete Asset
    public function deleteAsset($id)
    {
        Asset::destroy($id);
        return back()->with('success', 'Asset deleted successfully.');
    }

    
    public function editVendor($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function updateVendor(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:vendors,name,'.$id,
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);
        $vendor->update($validated);
        return redirect()->route('admin.dashboard')->with('success', 'Vendor updated successfully.');
    }

    public function deleteVendor($id)
    {
        Vendor::destroy($id);
        return back()->with('success', 'Vendor deleted successfully.');
    }
}
