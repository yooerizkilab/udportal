<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tickets;
use App\Models\TicketsCategories;
use App\Models\Department;

class TicketingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view tickets', ['only' => ['index', 'show']]);
        $this->middleware('permission:create tickets', ['only' => ['create', 'store']]);
        $this->middleware('permission:update tickets', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete tickets', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pastikan pengguna sudah login
        if (!auth()->check()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();

        // Query dasar untuk tiket dengan eager loading
        $query = Tickets::with([
            'category',
            'assignee',
            'user'
        ])->withCount('comments');

        // Logika berdasarkan peran pengguna
        if ($user->hasRole('Superadmin')) {
            // Superadmin melihat semua tiket
            $tickets = $query->orderBy('id', 'desc')->paginate(12);

            // Hitung widget untuk superadmin
            $widget = Tickets::selectRaw('
            SUM(CASE WHEN status = "Open" THEN 1 ELSE 0 END) as open,
            SUM(CASE WHEN status = "Closed" THEN 1 ELSE 0 END) as closed,
            SUM(CASE WHEN status = "In Progress" THEN 1 ELSE 0 END) as inprogress,
            SUM(CASE WHEN status = "Cancelled" THEN 1 ELSE 0 END) as cancelled
        ')->first();
        } elseif ($user->hasRole('Admin')) {
            // Admin melihat tiket yang di-assign kepadanya
            $tickets = $query
                ->where('assignee_to', $user->id)
                ->orderBy('id', 'desc')
                ->paginate(12);

            // Hitung widget untuk admin (hanya tiket yang di-assign)
            $widget = Tickets::where('assignee_to', $user->id)
                ->selectRaw('
                SUM(CASE WHEN status = "Open" THEN 1 ELSE 0 END) as open,
                SUM(CASE WHEN status = "Closed" THEN 1 ELSE 0 END) as closed,
                SUM(CASE WHEN status = "In Progress" THEN 1 ELSE 0 END) as inprogress,
                SUM(CASE WHEN status = "Cancelled" THEN 1 ELSE 0 END) as cancelled
            ')->first();
        } else {
            // Pengguna biasa hanya melihat tiket miliknya
            $tickets = $query
                ->where('user_id', $user->id)
                ->orderBy('id', 'desc')
                ->paginate(12);
        }

        return view('ticketing.index', compact('tickets', 'widget'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = TicketsCategories::all();
        $departments = Department::all();
        $tickets = Tickets::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
        return view('ticketing.create', compact('tickets', 'categories', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation request
        $request->validate([
            'category_id' => 'required|exists:tickets_categories,id',
            'assignee_to' => 'required|exists:department,id',
            'title' => 'required|string|max:100',
            'priority' => 'required|string|in:Low,Medium,High',
            'description' => 'required|string',
        ]);
        // Generate code Ticket EX : Ticket-00001
        $code = 'Ticket-' . str_pad(Tickets::count() + 1, 5, '0', STR_PAD_LEFT);

        // Store data
        $data = [
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'assignee_to' => $request->assignee_to,
            'code' => $code,
            'title' => $request->title,
            'description' => $request->description, // From summernote
            'priority' => $request->priority,
        ];

        DB::beginTransaction();
        try {
            Tickets::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Ticket created successfully');
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
        $tickets = Tickets::with('category', 'assignee', 'user', 'fixed', 'comments')->find($id);
        return view('ticketing.show', compact('tickets'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
