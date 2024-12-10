<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tickets;
use App\Models\TicketsCategories;
use App\Models\Department;
use App\Models\User;
use PHPUnit\Framework\Attributes\Ticket;

class TicketingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view ticket', ['only' => ['index', 'show']]);
        $this->middleware('permission:create ticket', ['only' => ['create', 'store']]);
        $this->middleware('permission:update ticket', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete ticket', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil user yang sedang login dan relasi employe
        $user = User::with(['employe', 'roles'])->find(auth()->user()->id);
        $isSuperadmin = $user->roles->contains('name', 'Superadmin');

        // Query dasar untuk tiket
        $ticketsQuery = Tickets::with('category', 'assignee', 'user', 'fixed')
            ->orderBy('id', 'desc');
        // Filter tiket berdasarkan role user
        if ($isSuperadmin) {
            // Superadmin melihat semua tiket
            $tickets = $ticketsQuery->paginate(12);
        } else {
            // Admin melihat tiket berdasarkan department_id dari assignee
            $tickets = $ticketsQuery->whereHas('assignee', function ($query) use ($user) {
                $query->where('assignee_id', $user->employe->department_id);
            })->paginate(12);
        }

        // Hitung widget berdasarkan status tiket
        $widget = Tickets::where('assignee_id', $user->employe->id)->selectRaw('
                SUM(CASE WHEN status = "Open" THEN 1 ELSE 0 END) as open,
                SUM(CASE WHEN status = "Closed" THEN 1 ELSE 0 END) as closed,
                SUM(CASE WHEN status = "In Progress" THEN 1 ELSE 0 END) as inprogress,
                SUM(CASE WHEN status = "Cancelled" THEN 1 ELSE 0 END) as cancelled
            ')->first();

        // Tampilkan view dengan data tiket dan widget
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
