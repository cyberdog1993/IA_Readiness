<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\DiagnosisExportService;
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
        return response($this->exports->toMarkdown($lead))
            ->header('Content-Type', 'text/markdown; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="diagnostico-'.$lead->ruc.'.md"');
    }

    public function json(Lead $lead): JsonResponse
    {
        return response()->json($this->exports->toArray($lead), 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function excel(Lead $lead): BinaryFileResponse
    {
        return $this->exports->downloadExcel($lead);
    }

    public function word(Lead $lead): BinaryFileResponse
    {
        return $this->exports->downloadWord($lead);
    }
}

