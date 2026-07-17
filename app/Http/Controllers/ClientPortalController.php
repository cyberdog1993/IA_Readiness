<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ProcessModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientPortalController extends Controller
{
    public function index(Request $request): View
    {
        $client = $this->currentClient($request);
        abort_unless($client, 404);

        $client->loadCount('processes');
        $client->load([
            'lead',
            'processes' => fn ($query) => $query->latest()->withCount([
                'steps',
                'systems',
                'documents',
                'problems',
                'opportunities',
                'evaluations',
                'backlogItems',
            ])->with(['steps', 'systems', 'documents', 'problems', 'opportunities', 'evaluations', 'backlogItems']),
        ]);

        return view('portal.index', [
            'client' => $client,
            'processes' => $client->processes,
        ]);
    }

    public function show(Request $request, ProcessModel $process): View
    {
        $client = $this->currentClient($request);
        abort_unless($client, 404);
        $this->authorizeClientProcessAccess($request, $process);

        $process->load([
            'client.lead',
            'steps',
            'systems',
            'documents',
            'problems',
            'opportunities',
            'evaluations',
            'backlogItems',
        ]);

        return view('portal.process', [
            'client' => $client,
            'process' => $process,
        ]);
    }

    private function currentClient(Request $request): ?Client
    {
        $clientId = $request->session()->get('consulting_intake_client_id') ?: $request->user()?->client_id;

        return $clientId ? Client::withCount('processes')->find($clientId) : null;
    }

    private function authorizeClientProcessAccess(Request $request, ProcessModel $process): void
    {
        $user = $request->user();
        abort_unless($user, 403);

        if (in_array($user->role, ['admin', 'internal'], true)) {
            return;
        }

        abort_unless($user->role === 'client' && (string) $user->client_id === (string) $process->client_id, 403);
    }
}
