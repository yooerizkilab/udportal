<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        $companies = Company::all();
        return view('settings.companymanage.department', compact('departments', 'companies'));
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
        // validate the form data
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);


        // create a new department
        $data = [
            'company_id' => $request->company_id,
            'code' => 'D' . str_pad(Department::count() + 1, 3, '0', STR_PAD_LEFT),
            'name' => $request->name,
            'description' => $request->description,
        ];

        DB::beginTransaction();
        try {
            $department = Department::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Department ' . $department->name . ' created successfully');
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
        $departments = Department::with('company')->findOrFail($id);
        return view('settings.companymanage.departmentshow', compact('departments'));
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
        // validate the form data
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        // update the department
        $data = [
            'company_id' => $request->company_id,
            'name' => $request->name,
            'description' => $request->description,
        ];

        DB::beginTransaction();
        try {
            $department = Department::findOrFail($id);
            $department->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Department ' . $department->name . ' updated successfully');
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
            $department = Department::find($id);
            $department->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Department ' . $department->name . ' deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
