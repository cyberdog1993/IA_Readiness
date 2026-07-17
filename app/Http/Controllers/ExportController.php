<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\DiagnosisExportService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends Controller
{
    public function __construct(private readonly DiagnosisExportService $exports)
    {
    }

    public function markdown(Lead $lead): Response
    {
        $this->authorizeLeadAccess($lead);

        return response($this->exports->toMarkdown($lead))
            ->header('Content-Type', 'text/markdown; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="diagnostico-'.$lead->ruc.'.md"');
    }

    public function json(Lead $lead): JsonResponse
    {
        $this->authorizeLeadAccess($lead);

        return response()->json($this->exports->toArray($lead), 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function excel(Lead $lead): BinaryFileResponse
    {
        $this->authorizeLeadAccess($lead);

        return $this->exports->downloadExcel($lead);
    }

    public function word(Lead $lead): BinaryFileResponse
    {
        $this->authorizeLeadAccess($lead);

        return $this->exports->downloadWord($lead);
    }

    public function clientPdf(Lead $lead): BinaryFileResponse
    {
        $this->authorizeLeadAccess($lead);

        return $this->exports->downloadClientPdf($lead);
    }

    public function internalPdf(Lead $lead): BinaryFileResponse
    {
        $this->authorizeInternalLeadAccess();

        return $this->exports->downloadInternalPdf($lead);
    }

    public function automationPayload(Lead $lead): JsonResponse
    {
        $this->authorizeLeadAccess($lead);

        return response()->json($this->exports->toAutomationPayload($lead), 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    private function authorizeLeadAccess(Lead $lead): void
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        if (in_array($user->role, ['admin', 'internal'], true)) {
            return;
        }

        if ($user->role !== 'client') {
            abort(403);
        }

        $lead->loadMissing('client');

        abort_unless($user->client_id && $lead->client?->id && (string) $user->client_id === (string) $lead->client->id, 403);
    }

    private function authorizeInternalLeadAccess(): void
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        abort_unless(in_array($user->role, ['admin', 'internal'], true), 403);
    }
}
