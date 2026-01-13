<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Project;
use App\Models\Worker;
use App\Models\LaborCost;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Project $project, Request $request)
    {
        $this->authorize('view', $project);

        $recipientType = $request->get('type');
        $status = $request->get('status');

        $query = $project->payments()->with('recipient');

        if ($recipientType) {
            $query->where('recipient_type', $recipientType);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $payments = $query->latest()->get();

        // Calculate totals
        $contractors = $project->contractorCosts()->contractors()->get();
        $workers = $project->workers()->active()->get();

        $paymentStats = [
            'total_to_contractors' => $project->payments()->toContractors()->sum('amount'),
            'total_to_workers' => $project->payments()->toWorkers()->sum('amount'),
            'total_payments' => $payments->sum('amount'),
        ];

        return view('payments.index', compact(
            'project',
            'payments',
            'contractors',
            'workers',
            'paymentStats'
        ));
    }

    public function create(Project $project)
    {
        $this->authorize('view', $project);

        $contractors = $project->contractorCosts()->contractors()->get();
        $workers = $project->workers()->active()->with('primaryContractor')->get();

        $paymentMethods = [
            'cash' => 'Cash',
            'bank_transfer' => 'Bank Transfer',
            'check' => 'Check',
            'upi' => 'UPI',
            'other' => 'Other'
        ];

        return view('payments.create', compact(
            'project',
            'contractors',
            'workers',
            'paymentMethods'
        ));
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $validated = $request->validate([
            'recipient_type' => 'required|in:contractor,worker',
            'recipient_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,check,upi,other',
            'transaction_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date|after_or_equal:period_start',
        ]);

        $validated['project_id'] = $project->id;
        $validated['status'] = 'paid';

        // Validate recipient exists and belongs to project
        if ($validated['recipient_type'] === 'contractor') {
            $contractor = LaborCost::find($validated['recipient_id']);
            if (!$contractor || $contractor->project_id !== $project->id || $contractor->labor_type !== 'contractor') {
                return back()->withInput()->withErrors(['recipient_id' => 'Invalid contractor selected.']);
            }
        } else {
            $worker = Worker::find($validated['recipient_id']);
            if (!$worker || $worker->project_id !== $project->id) {
                return back()->withInput()->withErrors(['recipient_id' => 'Invalid worker selected.']);
            }
        }

        Payment::create($validated);

        return redirect()->route('projects.payments.index', $project)
            ->with('success', 'Payment recorded successfully.');
    }

    public function edit(Project $project, Payment $payment)
    {
        $this->authorize('view', $project);

        if ($payment->project_id !== $project->id) {
            abort(404);
        }

        $contractors = $project->contractorCosts()->contractors()->get();
        $workers = $project->workers()->active()->get();

        $paymentMethods = [
            'cash' => 'Cash',
            'bank_transfer' => 'Bank Transfer',
            'check' => 'Check',
            'upi' => 'UPI',
            'other' => 'Other'
        ];

        return view('payments.edit', compact(
            'project',
            'payment',
            'contractors',
            'workers',
            'paymentMethods'
        ));
    }

    public function update(Request $request, Project $project, Payment $payment)
    {
        $this->authorize('view', $project);

        if ($payment->project_id !== $project->id) {
            abort(404);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,check,upi,other',
            'transaction_reference' => 'nullable|string|max:255',
            'status' => 'required|in:pending,partial,paid,cancelled',
            'notes' => 'nullable|string',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date|after_or_equal:period_start',
        ]);

        $payment->update($validated);

        return redirect()->route('projects.payments.index', $project)
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Project $project, Payment $payment)
    {
        $this->authorize('view', $project);

        if ($payment->project_id !== $project->id) {
            abort(404);
        }

        $payment->delete();

        return redirect()->route('projects.payments.index', $project)
            ->with('success', 'Payment deleted successfully.');
    }
}
