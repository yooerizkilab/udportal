<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Branch;

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
        $this->middleware('permission:view users', ['only' => ['index']]);
        $this->middleware('permission:create users', ['only' => ['create', 'store', 'importUsers']]);
        $this->middleware('permission:update users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete users', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all users & roles
        $users = User::all();
        $roles = Role::all();
        $companies = Company::all();
        $departments = Department::all();
        $branches = Branch::all();
        return view('settings.usersmanagement.index', compact('users', 'roles', 'companies', 'departments', 'branches'));
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
        $request->validate([
            'nik' => 'required|string|max:16|unique:employees,nik',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|exists:roles,id',
            'phone' => 'required|numeric|unique:employees,phone|min:10',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|integer|min:0',
            'position' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'required|exists:departments,id',
            'branch_id' => 'required|exists:branches,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate randomstring for employee
        $randomString = substr(str_shuffle(str_repeat($x = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4 / strlen($x)))), 1, 3);
        // Generate code default employe
        $code = 'EMP' . $randomString  . str_pad(User::count() + 1, 3, '0', STR_PAD_LEFT);

        // Upload photo
        $fileName = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/employees/photo', $fileName);
        }

        // Users
        $users = [
            'name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        // Employe
        $employe = [
            'user_id' => User::latest()->first()->id,
            'company_id' => $request->company_id,
            'department_id' => $request->department_id,
            'branch_id' => $request->branch_id,
            'code' => $code,
            'nik' => $request->nik,
            'full_name' => $request->first_name . ' ' . $request->last_name,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'position' => $request->position,
            'age' => $request->age,
            'photo' => $fileName
        ];

        // Insert into database
        DB::beginTransaction();
        try {
            $user = User::create($users);
            $user->employe()->create($employe);
            $role = Role::findById($request->roles);
            $user->assignRole($role->name);
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User ' . $user->fullName . ' created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::with('employe.company', 'employe.department', 'employe.branch')->findOrFail($id);
        // return $users;
        return view('settings.usersmanagement.showuser', compact('users'));
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
        // Get the user & employe data
        $users = User::with('employe')->findOrFail($id);

        // Validasi input
        $request->validate([
            'nik' => 'required|string|max:16|unique:employees,nik,' . $users->employe->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $users->id,
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $users->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|exists:roles,id',
            'phone' => 'nullable|numeric|unique:employees,phone,' . $users->employe->id,
            'gender' => 'nullable|in:Male,Female',
            'age' => 'nullable|integer|min:0',
            'position' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'branch_id' => 'nullable|exists:branches,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Jika photo diubah maka hapus photo lama
        $fileName = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/employees/photo', $fileName);
        }

        // Jika password tidak diubah, gunakan password lama
        $request->merge(['password' => $request->password ? Hash::make($request->password) : $users->password]);

        // Data untuk update user
        $userUpdate = $request->only([
            'username',
            'email',
            'password',
            'last_name'
        ]);
        $userUpdate['name'] = $request->first_name;

        // Data untuk update employe
        $employeUpdate = $request->only([
            'company_id',
            'department_id',
            'branch_id',
            'nik',
            'gender',
            'phone',
            'address',
            'position',
            'age',
        ]);
        $employeUpdate['photo'] = $fileName;
        $employeUpdate['full_name'] = $request->first_name . ' ' . $request->last_name;

        // Update data to database
        DB::beginTransaction();
        try {
            $users->update($userUpdate);
            $users->employe()->update($employeUpdate);

            // Sinkronisasi role
            $role = Role::findById($request->roles);
            $users->syncRoles([$role->name]);

            DB::commit();
            return redirect()->back()->with('success', 'User ' . $users->fullName . ' updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->delete();
            DB::commit();
            return redirect()->back()->with('success', 'User ' . $user->fullName . ' deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
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
