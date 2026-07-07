<?php

namespace Database\Seeders;

use App\Models\AutomationOpportunity;
use App\Models\BacklogItem;
use App\Models\Client;
use App\Models\CurrentProblem;
use App\Models\DocumentEvidence;
use App\Models\InternalEvaluation;
use App\Models\Lead;
use App\Models\ProcessModel;
use App\Models\ProcessStep;
use App\Models\SystemIntegration;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $lead = Lead::updateOrCreate(
            ['ruc' => '20123456789'],
            [
                'company_name' => 'NUVO',
                'industry' => 'Servicios',
                'contact_name' => 'María Torres',
                'contact_role' => 'Gerente de Operaciones',
                'email' => 'maria.torres@nuvocloud.pe',
                'phone' => '+51 999 888 777',
                'company_size' => '51-200',
                'repetitive_process_count' => 18,
                'manual_hours_weekly' => 32,
                'process_documentation_level' => 40,
                'digital_system_usage' => 72,
                'excel_dependency' => 78,
                'system_integration_level' => 35,
                'manual_report_generation' => 82,
                'has_kpis' => true,
                'key_person_dependency' => 68,
                'automation_interest' => 90,
                'maturity_score' => 74,
                'maturity_level' => 'Intermedio',
                'diagnosis_brief' => 'NUVO muestra una base digital razonable, pero aún depende de Excel, validaciones manuales y reportes operativos que consumen tiempo significativo.',
                'opportunities_summary' => 'Hay una oportunidad clara en automatizar reportes recurrentes, consolidar datos desde Monday/Kaseya/PSA/SharePoint y reducir la dependencia de tareas manuales.',
                'recommendation' => 'Arrancar con un piloto sobre gestión de reportes y sincronización de datos, priorizando un ahorro rápido y medible.',
                'status' => 'qualified',
            ]
        );

        $client = Client::updateOrCreate(
            ['ruc' => '20123456789'],
            [
                'lead_id' => $lead->id,
                'business_name' => 'NUVO',
                'industry' => 'Servicios',
                'address' => 'Av. Demo 123, Lima',
                'main_contact' => 'María Torres',
                'contact_role' => 'Gerente de Operaciones',
                'email' => 'maria.torres@nuvocloud.pe',
                'phone' => '+51 999 888 777',
                'status' => 'active',
                'notes' => 'Caso demo inicial para diagnóstico de automatización.',
            ]
        );

        $process = ProcessModel::updateOrCreate(
            ['name' => 'Gestión de Reportes', 'client_id' => $client->id],
            [
                'lead_id' => $lead->id,
                'area' => 'Operaciones',
                'owner' => 'Equipo de Analítica',
                'frequency' => 'Diario / Semanal',
                'objective' => 'Consolidar información operativa y emitir reportes confiables para la gerencia.',
                'expected_result' => 'Reportes generados con menor esfuerzo y mayor trazabilidad.',
                'trigger_event' => 'Cierre diario o solicitud de gerencia.',
                'validation_method' => 'Revisión de integridad y aprobación del responsable.',
                'status' => 'active',
            ]
        );

        $systems = [
            ['Monday', 'https://monday.com', 'SaaS', true, 'SSO / API token', 'Operaciones', 'ok'],
            ['Kaseya One', 'https://one.kaseya.com', 'PSA', true, 'OAuth', 'TI', 'ok'],
            ['PSA', null, 'Service desk', true, 'API key', 'Operaciones', 'ok'],
            ['SharePoint', 'https://sharepoint.com', 'DMS', true, 'Microsoft 365', 'Administración', 'ok'],
        ];

        foreach ($systems as [$name, $url, $type, $hasApi, $auth, $owner, $status]) {
            SystemIntegration::updateOrCreate(
                ['process_id' => $process->id, 'name' => $name],
                [
                    'client_id' => $client->id,
                    'url' => $url,
                    'system_type' => $type,
                    'has_api' => $hasApi,
                    'auth_type' => $auth,
                    'access_owner' => $owner,
                    'access_status' => $status,
                    'notes' => 'Sistema involucrado en el flujo de reportes NUVO.',
                ]
            );
        }

        $steps = [
            [1, 'Descargar datos desde Monday y PSA.', 'Analista', 'Monday / PSA', 'Solicitudes abiertas', 'Archivo CSV', 18, 'Exportaciones de sistema', 'Trabajo manual repetitivo', 'sí'],
            [2, 'Consolidar archivos en Excel maestro.', 'Analista', 'Excel', 'CSV múltiples', 'Base consolidada', 30, 'Libro Excel', 'Errores de fórmula', 'parcial'],
            [3, 'Validar información con SharePoint y correo.', 'Coordinador', 'SharePoint / Outlook', 'Base consolidada', 'Aprobación', 20, 'Capturas y correos', 'Esperas por aprobación', 'parcial'],
            [4, 'Generar reporte final para gerencia.', 'Analista', 'Word / Excel', 'Base aprobada', 'PDF / DOCX', 26, 'Reporte entregado', 'Toma mucho tiempo', 'sí'],
        ];

        foreach ($steps as [$number, $description, $owner, $system, $input, $output, $minutes, $evidence, $problem, $automatable]) {
            ProcessStep::updateOrCreate(
                ['process_id' => $process->id, 'step_number' => $number],
                [
                    'description' => $description,
                    'owner' => $owner,
                    'system_used' => $system,
                    'input' => $input,
                    'output' => $output,
                    'estimated_minutes' => $minutes,
                    'evidence_generated' => $evidence,
                    'problems' => $problem,
                    'automatable' => $automatable,
                ]
            );
        }

        CurrentProblem::updateOrCreate(
            ['process_id' => $process->id, 'description' => 'Consolidación manual de datos en Excel'],
            [
                'impact' => 'Alto',
                'frequency' => 'Diaria',
                'risk' => 'Operativo',
                'comments' => 'Genera retrabajo, errores de versión y retrasos en la entrega.',
            ]
        );

        AutomationOpportunity::updateOrCreate(
            ['process_id' => $process->id, 'activity' => 'Automatizar consolidación de reportes'],
            [
                'current_time_minutes' => 94,
                'expected_time_minutes' => 10,
                'estimated_savings_minutes' => 84,
                'suggested_technology' => 'Hermes Agent, MCP, n8n, IA, API, OCR',
                'priority' => 'alta',
                'complexity' => 3,
                'status' => 'proposed',
                'notes' => 'Base para la propuesta comercial y el backlog técnico.',
            ]
        );

        InternalEvaluation::updateOrCreate(
            ['process_id' => $process->id],
            [
                'complexity' => 3,
                'risk' => 3,
                'impact' => 5,
                'requires_mcp' => true,
                'requires_hermes_skill' => true,
                'requires_n8n' => true,
                'requires_ai' => true,
                'requires_ocr' => false,
                'estimated_hours' => 150,
                'technical_notes' => 'Caso ideal para flujo orquestado con múltiples integraciones.',
            ]
        );

        BacklogItem::updateOrCreate(
            ['process_id' => $process->id, 'title' => 'Historia base de automatización'],
            [
                'type' => 'historia de usuario',
                'description' => 'Como analista de operaciones quiero consolidar reportes automáticamente para reducir trabajo manual.',
                'acceptance_criteria' => 'El reporte se genera en menos de 10 minutos y queda trazabilidad en SharePoint.',
                'priority' => 'alta',
                'responsible' => 'Arquitectura / Automatización',
                'status' => 'draft',
                'estimated_hours' => 24,
            ]
        );
    }
}
