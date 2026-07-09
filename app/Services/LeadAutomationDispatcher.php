<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeadAutomationDispatcher
{
    public function __construct(private readonly DiagnosisExportService $exports)
    {
    }

    public function dispatch(Lead $lead): array
    {
        $payload = $this->exports->toAutomationPayload($lead);
        $targets = array_filter([
            'lead_created' => config('services.automation.lead_created_webhook'),
            'n8n' => config('services.automation.n8n_webhook'),
            'crm' => config('services.automation.crm_webhook'),
            'internal_notify' => config('services.automation.internal_notify_webhook'),
        ]);

        $results = [];

        foreach ($targets as $name => $url) {
            try {
                $response = Http::timeout(8)->acceptJson()->post($url, [
                    'source' => 'consultores-it-automation-platform',
                    'event' => $name,
                    'lead' => $payload,
                ]);

                $results[$name] = [
                    'ok' => $response->successful(),
                    'status' => $response->status(),
                ];
            } catch (ConnectionException $e) {
                Log::warning('No se pudo enviar el webhook de automatización', [
                    'event' => $name,
                    'lead_id' => $lead->id,
                    'message' => $e->getMessage(),
                ]);

                $results[$name] = [
                    'ok' => false,
                    'status' => null,
                ];
            }
        }

        return $results;
    }
}
