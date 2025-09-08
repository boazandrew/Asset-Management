<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AssetAssignment;

class UserController
{
    public function dashboard()
    {

        $assignments = AssetAssignment::with(['asset', 'asset.vendor'])
            ->where('user_id', Auth::id())
            ->orderBy('assigned_date', 'desc')
            ->get();

        return view('user.dashboard', compact('assignments'));
    }

    public function acknowledgeAssignment(Request $request, $assignmentId)
    {

        $assignment = AssetAssignment::where('id', $assignmentId)
            ->where('user_id', Auth::id())
            ->first();

        if ($assignment) {
            $assignment->update([
                'acknowledged' => true,
                'acknowledged_at' => now(),
            ]);
            return back()->with('success', 'Asset Acknowledged Successfully!');
        }
        return back()->with('error', 'Asset not found or not assigned to you.');
    }
}
