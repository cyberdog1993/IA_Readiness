<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\LeadAutomationDispatcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadAutomationController extends Controller
{
    public function dispatch(Request $request, Lead $lead, LeadAutomationDispatcher $dispatcher): JsonResponse|RedirectResponse
    {
        $results = $dispatcher->dispatch($lead);

        if ($request->expectsJson()) {
            return response()->json([
                'lead_id' => $lead->id,
                'dispatched' => $results,
            ]);
        }

        return back()->with('status', 'webhook-dispatch')->with('webhook_results', $results);
    }
}
