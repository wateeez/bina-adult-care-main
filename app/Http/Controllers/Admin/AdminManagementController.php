<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserAdmin;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminManagementController extends Controller
{
    /**
     * Display list of all admins (Super Admin only)
     */
    public function index()
    {
        $admins = UserAdmin::orderBy('created_at', 'desc')->get();
        $currentAdmin = UserAdmin::find(session('admin_id'));
        
        return view('admin.admins.index', compact('admins', 'currentAdmin'));
    }

    /**
     * Show create admin form
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store new admin
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:user_admin,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'role' => 'required|in:super_admin,content_editor'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validate password strength
        $passwordErrors = UserAdmin::validatePasswordStrength($request->password);
        if (!empty($passwordErrors)) {
            return back()->withErrors(['password' => $passwordErrors])->withInput();
        }

        $admin = UserAdmin::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true
        ]);

        // Log activity
        AdminActivityLog::logActivity(
            session('admin_id'),
            'create',
            'admins',
            'Created new admin account: ' . $admin->email,
            null,
            ['email' => $admin->email, 'role' => $admin->role]
        );

        return redirect()->route('admin.admins.index')->with('success', 'Admin account created successfully');
    }

    /**
     * Show edit admin form
     */
    public function edit($id)
    {
        $admin = UserAdmin::findOrFail($id);
        $currentAdmin = UserAdmin::find(session('admin_id'));

        // Prevent editing yourself
        if ($admin->id === $currentAdmin->id) {
            return redirect()->route('admin.admins.index')->with('error', 'You cannot edit your own account here. Use profile settings.');
        }

        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update admin
     */
    public function update(Request $request, $id)
    {
        $admin = UserAdmin::findOrFail($id);
        $currentAdmin = UserAdmin::find(session('admin_id'));

        // Prevent editing yourself
        if ($admin->id === $currentAdmin->id) {
            return redirect()->route('admin.admins.index')->with('error', 'You cannot edit your own account.');
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:user_admin,email,' . $id,
            'role' => 'required|in:super_admin,content_editor',
            'is_active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $oldValues = $admin->only(['email', 'role', 'is_active']);

        $admin->update([
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->is_active
        ]);

        $newValues = $admin->only(['email', 'role', 'is_active']);

        // Log activity
        AdminActivityLog::logActivity(
            session('admin_id'),
            'update',
            'admins',
            'Updated admin account: ' . $admin->email,
            $oldValues,
            $newValues
        );

        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully');
    }

    /**
     * Change admin password (Super Admin can change any password)
     */
    public function changePassword(Request $request, $id)
    {
        $admin = UserAdmin::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'required|same:new_password'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // Validate password strength
        $passwordErrors = UserAdmin::validatePasswordStrength($request->new_password);
        if (!empty($passwordErrors)) {
            return back()->withErrors(['new_password' => $passwordErrors]);
        }

        $admin->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Log activity
        AdminActivityLog::logActivity(
            session('admin_id'),
            'password_change',
            'admins',
            'Changed password for admin: ' . $admin->email,
            null,
            ['target_admin' => $admin->email]
        );

        return back()->with('success', 'Password changed successfully');
    }

    /**
     * Delete admin
     */
    public function destroy($id)
    {
        $admin = UserAdmin::findOrFail($id);
        $currentAdmin = UserAdmin::find(session('admin_id'));

        // Prevent deleting yourself
        if ($admin->id === $currentAdmin->id) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $adminEmail = $admin->email;

        // Log activity before deletion
        AdminActivityLog::logActivity(
            session('admin_id'),
            'delete',
            'admins',
            'Deleted admin account: ' . $adminEmail,
            $admin->only(['email', 'role']),
            null
        );

        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully');
    }

    /**
     * Show activity logs
     */
    public function activityLogs()
    {
        $logs = AdminActivityLog::with('admin')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.admins.activity-logs', compact('logs'));
    }
}
