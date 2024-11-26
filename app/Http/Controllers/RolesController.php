<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /** 
     * Create a new controller instance.
     * @return void
     * */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('settings.usersmanagement.roles', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = [
            'name' => $request->name,
        ];

        DB::beginTransaction();
        try {
            $roles = Role::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Role ' . $roles->name . ' created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while creating the role.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = [
            'name' => $request->name,
        ];

        DB::beginTransaction();
        try {
            $role->name = $data['name'];
            $role->save();
            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Role ' . $role->name . ' updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', 'An error occurred while updating the role.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $roles = Role::findOrFail($id);
            $roles->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Role ' . $roles->name . ' deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while deleting the role.');
        }
    }

    /**
     * Assign permissions to a role
     * */
    public function assignPermissions(Request $request)
    {
        // Validasi input
        $request->validate([
            'role' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // cek jika role superadmin tidak bisa di assign
        // if ($request->role == 1) {
        //     return redirect()->back()->with('error', 'Superadmin role cannot be assigned permissions.');
        // }

        DB::beginTransaction();
        try {
            $role = Role::findOrFail($request->role);
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
            DB::commit();
            return redirect()->back()->with('success', 'Permissions successfully assigned to role ' . $role->name . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
