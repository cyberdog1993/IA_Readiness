<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use App\Services\LeadAutomationDispatcher;
use App\Services\MaturityCalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class LeadApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Lead::query()->latest()->paginate(15)
        );
    }

    public function show(Lead $lead): JsonResponse
    {
        return response()->json($lead->load(['processes.steps', 'processes.systems', 'processes.problems', 'processes.opportunities', 'processes.evaluations', 'processes.backlogItems']));
    }

    public function store(StoreLeadRequest $request, MaturityCalculator $calculator, LeadAutomationDispatcher $dispatcher): JsonResponse
    {
        $lead = $calculator->updateLead(new Lead(), $request->validated());
        $lead->update([
            'status' => 'new',
            'consulting_requested_at' => Carbon::now(),
        ]);

        $dispatcher->dispatch($lead);

        return response()->json($lead, 201);
    }
}
