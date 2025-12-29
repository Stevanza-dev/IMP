<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of roles
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show form untuk create role baru
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('guard_name');
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store role baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

            if ($request->has('permissions') && count($request->permissions) > 0) {
                $permissions = Permission::whereIn('id', $request->permissions)->get();
                $role->syncPermissions($permissions);
            }

            return redirect()->route('role.index')
                ->with('success', 'Role berhasil dibuat beserta dengan permissions-nya');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Show form untuk edit role
     */
    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all()->groupBy('guard_name');
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update role ke database
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id . '|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            $role->update([
                'name' => $request->name
            ]);

            if ($request->has('permissions')) {
                $permissions = Permission::whereIn('id', $request->permissions)->get();
                $role->syncPermissions($permissions);
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route('role.index')
                ->with('success', 'Role dan permissions berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Delete role
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);

        // Prevent delete super-admin role
        if ($role->name === 'super-admin') {
            return redirect()->back()
                ->with('error', 'Role Super Admin tidak bisa dihapus');
        }

        try {
            $role->delete();
            return redirect()->route('role.index')
                ->with('success', 'Role berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}

