<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * 
     * Create a new controller instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all users & roles
        $users = User::all();
        $roles = Role::all();

        return view('settings.usersmanagement.index', compact('users', 'roles'));
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
        // Validasi input dari form
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'roles' => 'required|exists:roles,id',
        ]);

        $data = [
            'name' => $validatedData['name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'email_verified_at' => now(),
        ];

        DB::beginTransaction();
        try {
            $user = User::create($data);
            $role = Role::findById($validatedData['roles']);
            $user->assignRole($role->name);
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User ' . $user->name . ' created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
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
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed', // Password opsional
            'roles' => 'required|exists:roles,id', // Pastikan role valid
        ]);

        // Get the user
        $users = User::findOrFail($id);

        // Data the user
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'last_name' => $request->last_name,
            'password' => $request->password ? Hash::make($request->password) : $users->password,
            'roles' => $request->roles,
        ];

        DB::beginTransaction();
        try {
            $users->update($data);
            $role = Role::findById($request->roles);
            $users->syncRoles([$role->name]);
            DB::commit();
            return redirect()->back()->with('success', 'User ' . $users->name . ' updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while updating the user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->back()->with('success', 'User ' . $user->name . ' deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the user.');
        }
    }

    public function exportPdf(Request $request)
    {
        // Validate the request
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Get the start date and end date
        $startDate = request('start_date');
        $endDate = request('end_date');

        $users = User::whereBetween('created_at', [$startDate, $endDate])->get();

        // $pdf = PDF::loadView('settings.usersmanagement.pdf', compact('users'));
        // return $pdf->stream('users.pdf');
    }

    public function exportExcel(Request $request)
    {
        // Validate the request
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Get the start date and end date
        $startDate = request('start_date');
        $endDate = request('end_date');

        $users = User::whereBetween('created_at', [$startDate, $endDate])->get();

        // return Excel::download(new UsersExport($users), 'users.xlsx');
    }

    public function importUsers(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|mimes:csv,xlsx, xls',
        ]);

        $file = $request->file('file');

        //move file to storage
        $path = $file->store('import');
        $file = storage_path('public/uploads/users/' . $path);

        // Excel::import(new UsersImport, $file);

        return redirect()->back()->with('success', 'Users imported successfully.');
    }
}
