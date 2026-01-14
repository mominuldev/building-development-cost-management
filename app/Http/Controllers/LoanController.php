<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanRepayment;
use App\Models\Project;
use App\Models\Worker;
use App\Models\LaborCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of loans for a project.
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $loans = Loan::where('project_id', $project->id)
            ->with('repayments')
            ->orderBy('loan_date', 'desc')
            ->get();

        // Calculate statistics
        $totalLoans = $loans->sum('amount');
        $totalRepaid = $loans->sum('amount_repaid');
        $totalPending = $loans->where('status', 'pending')->count();
        $totalPartial = $loans->where('status', 'partial')->count();
        $totalPaid = $loans->where('status', 'paid')->count();
        $totalOverdue = $loans->filter(fn($loan) => $loan->is_overdue)->count();

        // Group by recipient
        $recipients = $loans->groupBy(function ($loan) {
            return strtolower($loan->recipient_name) . '|' . ($loan->recipient_phone ?? '');
        })->map(function ($recipientLoans) {
            $firstLoan = $recipientLoans->first();
            return [
                'name' => $firstLoan->recipient_name,
                'phone' => $firstLoan->recipient_phone,
                'address' => $firstLoan->recipient_address,
                'nid' => $firstLoan->recipient_nid,
                'total_loans' => $recipientLoans->count(),
                'total_given' => $recipientLoans->sum('amount'),
                'total_repaid' => $recipientLoans->sum('amount_repaid'),
                'outstanding' => $recipientLoans->sum('amount') - $recipientLoans->sum('amount_repaid'),
                'loans' => $recipientLoans,
            ];
        })->sortByDesc('outstanding')->values();

        return view('loans.index', compact(
            'project',
            'loans',
            'recipients',
            'totalLoans',
            'totalRepaid',
            'totalPending',
            'totalPartial',
            'totalPaid',
            'totalOverdue'
        ));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create(Project $project)
    {
        $this->authorize('view', $project);

        // Get all unique recipients from existing loans
        $recipients = Loan::where('project_id', $project->id)
            ->select('recipient_name', 'recipient_phone', 'recipient_address', 'recipient_nid')
            ->distinct()
            ->get()
            ->map(function($recipient) use ($project) {
                // Calculate total loans and outstanding balance for this recipient
                $loans = Loan::where('project_id', $project->id)
                    ->where('recipient_name', $recipient->recipient_name)
                    ->where('recipient_phone', $recipient->recipient_phone)
                    ->get();

                return [
                    'name' => $recipient->recipient_name,
                    'phone' => $recipient->recipient_phone,
                    'address' => $recipient->recipient_address,
                    'nid' => $recipient->recipient_nid,
                    'total_loans' => $loans->count(),
                    'total_given' => $loans->sum('amount'),
                    'total_repaid' => $loans->sum('amount_repaid'),
                    'outstanding' => $loans->sum('amount') - $loans->sum('amount_repaid'),
                    'loans_count' => $loans->where('status', '!=', 'paid')->count(),
                ];
            })
            ->sortByDesc('outstanding')
            ->values();

        return view('loans.create', compact('project', 'recipients'));
    }

    /**
     * Store a newly created loan in storage.
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'nullable|string|max:20',
            'recipient_address' => 'nullable|string|max:500',
            'recipient_nid' => 'nullable|string|max:50',
            'amount' => 'required|numeric|min:0.01',
            'loan_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,check,online',
            'transaction_reference' => 'nullable|string|max:255',
            'due_date' => 'nullable|date|after:loan_date',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $loan = Loan::create([
            'project_id' => $project->id,
            'recipient_name' => $validated['recipient_name'],
            'recipient_phone' => $validated['recipient_phone'],
            'recipient_address' => $validated['recipient_address'],
            'recipient_nid' => $validated['recipient_nid'],
            'amount' => $validated['amount'],
            'loan_date' => $validated['loan_date'],
            'payment_method' => $validated['payment_method'],
            'transaction_reference' => $validated['transaction_reference'],
            'due_date' => $validated['due_date'],
            'interest_rate' => $validated['interest_rate'],
            'notes' => $validated['notes'],
            'status' => 'pending',
            'amount_repaid' => 0,
        ]);

        return redirect()
            ->route('projects.loans.index', $project)
            ->with('success', 'Loan created successfully.');
    }

    /**
     * Display the specified loan.
     */
    public function show(Project $project, Loan $loan)
    {
        $this->authorize('view', $project);

        if ($loan->project_id !== $project->id) {
            abort(404);
        }

        // Load loan with repayments
        $loan->load('repayments');

        // Return JSON if AJAX request
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'id' => $loan->id,
                'recipient_name' => $loan->recipient_name,
                'recipient_phone' => $loan->recipient_phone,
                'recipient_address' => $loan->recipient_address,
                'recipient_nid' => $loan->recipient_nid,
                'amount' => $loan->amount,
                'loan_date' => $loan->loan_date ? $loan->loan_date->format('Y-m-d') : null,
                'payment_method' => $loan->payment_method,
                'transaction_reference' => $loan->transaction_reference,
                'status' => $loan->status,
                'amount_repaid' => $loan->amount_repaid,
                'due_date' => $loan->due_date ? $loan->due_date->format('Y-m-d') : null,
                'interest_rate' => $loan->interest_rate,
                'notes' => $loan->notes,
                'payment_status_text' => $loan->payment_status_text,
                'remaining_balance' => $loan->remaining_balance,
                'repayments' => $loan->repayments->map(function($repayment) {
                    return [
                        'id' => $repayment->id,
                        'amount' => $repayment->amount,
                        'payment_date' => $repayment->payment_date->format('Y-m-d'),
                        'payment_method' => $repayment->payment_method,
                        'transaction_reference' => $repayment->transaction_reference,
                        'notes' => $repayment->notes,
                    ];
                })->toArray(),
            ]);
        }

        return view('loans.show', compact('project', 'loan'));
    }

    /**
     * Show the form for editing the specified loan.
     */
    public function edit(Project $project, Loan $loan)
    {
        $this->authorize('view', $project);

        if ($loan->project_id !== $project->id) {
            abort(404);
        }

        return view('loans.edit', compact('project', 'loan'));
    }

    /**
     * Update the specified loan in storage.
     */
    public function update(Request $request, Project $project, Loan $loan)
    {
        $this->authorize('view', $project);

        if ($loan->project_id !== $project->id) {
            abort(404);
        }

        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'nullable|string|max:20',
            'recipient_address' => 'nullable|string|max:500',
            'recipient_nid' => 'nullable|string|max:50',
            'amount' => 'required|numeric|min:0.01',
            'loan_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,check,online',
            'transaction_reference' => 'nullable|string|max:255',
            'due_date' => 'nullable|date|after:loan_date',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $loan->update($validated);

        return redirect()
            ->route('projects.loans.index', $project)
            ->with('success', 'Loan updated successfully.');
    }

    /**
     * Remove the specified loan from storage.
     */
    public function destroy(Project $project, Loan $loan)
    {
        $this->authorize('view', $project);

        if ($loan->project_id !== $project->id) {
            abort(404);
        }

        $loan->delete();

        return redirect()
            ->route('projects.loans.index', $project)
            ->with('success', 'Loan deleted successfully.');
    }

    /**
     * Record a repayment for a loan.
     */
    public function repay(Request $request, Project $project, Loan $loan)
    {
        $this->authorize('view', $project);

        if ($loan->project_id !== $project->id) {
            abort(404);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,check,online',
            'transaction_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Calculate new repaid amount
        $newRepaidAmount = min(
            $loan->amount,
            $loan->amount_repaid + $validated['amount']
        );

        // Create repayment record
        LoanRepayment::create([
            'loan_id' => $loan->id,
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'payment_method' => $validated['payment_method'],
            'transaction_reference' => $validated['transaction_reference'],
            'notes' => $validated['notes'],
        ]);

        // Update loan
        $loan->update([
            'amount_repaid' => $newRepaidAmount,
        ]);

        // Update loan status
        $loan->updateStatus();

        return redirect()
            ->route('projects.loans.index', $project)
            ->with('success', 'Repayment recorded successfully.');
    }

    /**
     * Show details for a specific recipient.
     */
    public function recipient(Project $project, $recipientName)
    {
        $this->authorize('view', $project);

        // Get all loans for this recipient
        $loans = Loan::where('project_id', $project->id)
            ->where('recipient_name', $recipientName)
            ->with('repayments')
            ->orderBy('loan_date', 'desc')
            ->get();

        if ($loans->isEmpty()) {
            abort(404);
        }

        // Get recipient info from first loan
        $recipient = [
            'name' => $loans->first()->recipient_name,
            'phone' => $loans->first()->recipient_phone,
            'address' => $loans->first()->recipient_address,
            'nid' => $loans->first()->recipient_nid,
        ];

        // Calculate totals
        $totalLoans = $loans->count();
        $totalGiven = $loans->sum('amount');
        $totalRepaid = $loans->sum('amount_repaid');
        $outstanding = $totalGiven - $totalRepaid;

        // Get all repayments for this recipient
        $allRepayments = $loans->pluck('repayments')->flatten()->sortByDesc('payment_date');

        return view('loans.recipient', compact(
            'project',
            'loans',
            'recipient',
            'allRepayments',
            'totalLoans',
            'totalGiven',
            'totalRepaid',
            'outstanding'
        ));
    }

    /**
     * Download loan history as PDF for a specific recipient.
     */
    public function downloadPdf(Project $project, $recipientName)
    {
        $this->authorize('view', $project);

        // Get all loans for this recipient
        $loans = Loan::where('project_id', $project->id)
            ->where('recipient_name', $recipientName)
            ->with('repayments')
            ->orderBy('loan_date', 'desc')
            ->get();

        if ($loans->isEmpty()) {
            abort(404);
        }

        // Get recipient info from first loan
        $recipient = [
            'name' => $loans->first()->recipient_name,
            'phone' => $loans->first()->recipient_phone,
            'address' => $loans->first()->recipient_address,
            'nid' => $loans->first()->recipient_nid,
        ];

        // Calculate totals
        $totalLoans = $loans->count();
        $totalGiven = $loans->sum('amount');
        $totalRepaid = $loans->sum('amount_repaid');
        $outstanding = $totalGiven - $totalRepaid;

        // Get all repayments for this recipient
        $allRepayments = $loans->pluck('repayments')->flatten()->sortByDesc('payment_date');

        // Generate filename
        $filename = 'loan_history_' . strtolower(str_replace(' ', '_', $recipient['name'])) . '_' . now()->format('Y-m-d') . '.pdf';

        // Generate PDF
        $pdf = PDF::loadView('loans.pdf', compact(
            'project',
            'loans',
            'recipient',
            'allRepayments',
            'totalLoans',
            'totalGiven',
            'totalRepaid',
            'outstanding'
        ));

        // Download PDF
        return $pdf->download($filename);
    }
}
