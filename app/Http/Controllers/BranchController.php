<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Branch;
use App\Models\Company;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::all();
        $companies = Company::all();
        return view('settings.companymanage.branch', compact('branches', 'companies'));
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
        // validate the request
        $request->validate([
            'company_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'database' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|string|in:Head Office,Branch Office',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // store the photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoFile = $request->name . '-' . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('img/branch'), $photoFile);
        }

        // create a new branch
        $data = [
            'company_id' => $request->company_id,
            'code' => 'B' . str_pad(Branch::count() + 1, 3, '0', STR_PAD_LEFT),
            'name' => $request->name,
            'database' => $request->database,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'type' => $request->type,
            'photo' => isset($photoFile) ? $photoFile : null
        ];

        DB::beginTransaction();
        try {
            Branch::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Branch ' . $request->name . ' created successfully');
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
        $branches = Branch::with('company')->findOrFail($id);
        return view('settings.companymanage.branchshow', compact('branches'));
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
        // validate the request
        $request->validate([
            'company_id' => 'required|string|exists:companies,id',
            'name' => 'required|string|max:255',
            'database' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'status' => 'required|string|in:Active,Inactive',
            'description' => 'nullable|string',
            'type' => 'required|string|in:Head Office,Branch Office',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // store the photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoFile = $request->name . '-' . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('img/branch'), $photoFile);
        }

        // update the branch
        $data = [
            'company_id' => $request->company_id,
            'name' => $request->name,
            'database' => $request->database,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
            'description' => $request->description,
            'type' => $request->type,
            'photo' => isset($photoFile) ? $photoFile : null
        ];

        DB::beginTransaction();
        try {
            $branch = Branch::find($id);
            $branch->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Branch ' . $branch->name . ' updated successfully');
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
            $branch = Branch::find($id);
            $branch->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Branch ' . $branch->name . ' deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
