<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use App\Services\MaturityCalculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function home(): View
    {
        return view('home');
    }

    public function create(): View
    {
        return view('landing', [
            'lead' => new Lead(),
        ]);
    }

    public function store(StoreLeadRequest $request, MaturityCalculator $calculator): RedirectResponse
    {
        $lead = $calculator->updateLead(new Lead(), $request->validated());
        $lead->update([
            'status' => 'new',
            'consulting_requested_at' => Carbon::now(),
        ]);

        return redirect()->route('diagnosis.show', $lead);
    }

    public function show(Lead $lead): View
    {
        return view('diagnosis.show', compact('lead'));
    }
}
