<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\LeadAutomationDispatcher;
use Illuminate\Http\JsonResponse;

class LeadAutomationController extends Controller
{
    public function dispatch(Lead $lead, LeadAutomationDispatcher $dispatcher): JsonResponse
    {
        return response()->json([
            'lead_id' => $lead->id,
            'dispatched' => $dispatcher->dispatch($lead),
        ]);
    }
}
