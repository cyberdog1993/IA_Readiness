<?php

namespace Database\Seeders;

use App\Models\AutomationOpportunity;
use App\Models\BacklogItem;
use App\Models\Client;
use App\Models\CurrentProblem;
use App\Models\DocumentEvidence;
use App\Models\InternalEvaluation;
use App\Models\Lead;
use App\Models\ProcessAssumption;
use App\Models\ProcessConstraint;
use App\Models\ProcessDecision;
use App\Models\ProcessDependency;
use App\Models\ProcessException;
use App\Models\ProcessMetric;
use App\Models\ProcessModel;
use App\Models\ProcessStakeholder;
use App\Models\ProcessStep;
use App\Models\SystemIntegration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoInternalIntakeSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $lead = Lead::updateOrCreate(
                ['ruc' => '20999999991'],
                [
                    'company_name' => 'Demo Automatización SAC',
                    'industry' => 'Servicios',
                    'contact_name' => 'Laura Pérez',
                    'contact_role' => 'Jefa de Operaciones',
                    'email' => 'laura.perez@demo-automatizacion.pe',
                    'phone' => '+51 999 888 777',
                    'company_size' => '51-200',
                    'repetitive_process_count' => 18,
                    'manual_hours_weekly' => 42,
                    'process_documentation_level' => 68,
                    'digital_system_usage' => 74,
                    'excel_dependency' => 61,
                    'system_integration_level' => 49,
                    'manual_report_generation' => 77,
                    'has_kpis' => true,
                    'key_person_dependency' => 58,
                    'automation_interest' => 92,
                    'privacy_consent' => true,
                    'maturity_score' => 74,
                    'maturity_level' => 'Intermedio',
                    'diagnosis_brief' => 'La operación tiene una base digital suficiente para acelerar automatizaciones con impacto comercial y operativo.',
                    'opportunities_summary' => 'Automatizar reportes, consolidar información entre sistemas y reducir reprocesos en Excel.',
                    'recommendation' => 'Iniciar por un piloto de reportes automáticos y una integración ligera entre CRM, correo y hojas de cálculo.',
                    'consulting_requested_at' => now(),
                    'version' => 2,
                    'consultant_name' => 'Julio Valdez',
                    'source' => 'demo_server_review',
                    'status' => 'qualified',
                ]
            );

            $client = Client::updateOrCreate(
                ['ruc' => $lead->ruc],
                [
                    'lead_id' => $lead->id,
                    'business_name' => $lead->company_name,
                    'industry' => $lead->industry,
                    'address' => 'Av. Demo 123, Lima',
                    'main_contact' => $lead->contact_name,
                    'contact_role' => $lead->contact_role,
                    'email' => $lead->email,
                    'phone' => $lead->phone,
                    'status' => 'active',
                    'notes' => 'Cliente ficticio para pruebas del formulario interno por secciones.',
                ]
            );

            $process = ProcessModel::updateOrCreate(
                [
                    'client_id' => $client->id,
                    'name' => 'Gestión de reportes comerciales',
                ],
                [
                    'lead_id' => $lead->id,
                    'area' => 'Operaciones',
                    'owner' => 'Laura Pérez',
                    'frequency' => 'Diario',
                    'objective' => 'Consolidar ventas, operaciones y seguimiento comercial en un reporte ejecutivo.',
                    'expected_result' => 'Reporte listo en menos de 10 minutos con datos consolidados y trazables.',
                    'trigger_event' => 'Cierre de la jornada o solicitud de gerencia.',
                    'validation_method' => 'El reporte se entrega sin reprocesos y con validación de datos cruzados.',
                    'status' => 'intake',
                    'version' => 2,
                    'state' => 'levantamiento',
                    'consultant_name' => 'Julio Valdez',
                    'priority' => 'alta',
                    'secondary_objectives' => 'Reducir reprocesos, mejorar trazabilidad y estandarizar evidencias.',
                    'business_problems' => 'Se copian datos manualmente desde varios sistemas y Excel es la fuente de consolidación.',
                    'completion_criteria' => 'El reporte queda automatizado, validado y distribuido al correo de gerencia.',
                    'start_event' => 'Apertura del libro de cierre diario.',
                    'end_event' => 'Reporte enviado y archivado.',
                    'frequency_number' => 1,
                    'frequency_period' => 'día',
                    'context_for_ai' => 'Caso ideal para automatización con IA, n8n, API y posible OCR en anexos.',
                    'category' => 'reporting',
                    'sector' => 'servicios',
                    'tags' => ['demo', 'reportes', 'automatizacion', 'ia'],
                    'notes' => 'Proceso ficticio para pruebas end-to-end.',
                ]
            );

            ProcessStakeholder::where('process_id', $process->id)->delete();
            ProcessDependency::where('process_id', $process->id)->delete();
            ProcessDecision::where('process_id', $process->id)->delete();
            ProcessException::where('process_id', $process->id)->delete();
            ProcessMetric::where('process_id', $process->id)->delete();
            ProcessConstraint::where('process_id', $process->id)->delete();
            ProcessAssumption::where('process_id', $process->id)->delete();
            ProcessStep::where('process_id', $process->id)->delete();
            SystemIntegration::where('process_id', $process->id)->delete();
            DocumentEvidence::where('process_id', $process->id)->delete();
            CurrentProblem::where('process_id', $process->id)->delete();
            AutomationOpportunity::where('process_id', $process->id)->delete();
            InternalEvaluation::where('process_id', $process->id)->delete();
            BacklogItem::where('process_id', $process->id)->delete();

            $step1 = ProcessStep::create([
                'process_id' => $process->id,
                'step_number' => 1,
                'title' => 'Recolectar fuentes',
                'description' => 'Descargar ventas, tickets y tareas pendientes desde Monday, Kaseya One, PSA y SharePoint.',
                'owner' => 'Analista',
                'system_used' => 'Monday / Kaseya One',
                'input' => 'Datos diarios',
                'output' => 'Archivos de exportación',
                'estimated_minutes' => 25,
                'min_minutes' => 20,
                'avg_minutes' => 25,
                'max_minutes' => 35,
                'wait_minutes' => 5,
                'frequency_volume' => 1,
                'execution_type' => 'manual',
                'requires_human_validation' => true,
                'sequence_type' => 'secuencial',
                'evidence_generated' => 'CSV y capturas',
                'problems' => 'Recolección manual desde varias ventanas y logins.',
                'automatable' => 'si',
                'comments' => 'Candidato ideal para API + descarga automática.',
            ]);

            $step2 = ProcessStep::create([
                'process_id' => $process->id,
                'step_number' => 2,
                'title' => 'Consolidar',
                'description' => 'Normalizar columnas, quitar duplicados y cruzar información en Excel.',
                'owner' => 'Asistente de Operaciones',
                'system_used' => 'Excel',
                'input' => 'Exportaciones CSV',
                'output' => 'Base consolidada',
                'estimated_minutes' => 38,
                'min_minutes' => 30,
                'avg_minutes' => 38,
                'max_minutes' => 50,
                'wait_minutes' => 10,
                'frequency_volume' => 1,
                'execution_type' => 'manual',
                'requires_human_validation' => true,
                'sequence_type' => 'decisional',
                'evidence_generated' => 'Libro consolidado',
                'problems' => 'Uso crítico de fórmulas y reprocesos.',
                'automatable' => 'parcial',
                'comments' => 'Puede apoyarse con IA para validación.',
            ]);

            ProcessStep::create([
                'process_id' => $process->id,
                'step_number' => 3,
                'title' => 'Emitir y enviar',
                'description' => 'Generar reporte final y enviarlo por correo a gerencia.',
                'owner' => 'Jefatura',
                'system_used' => 'Outlook / SharePoint',
                'input' => 'Base consolidada',
                'output' => 'Reporte PDF y archivo histórico',
                'estimated_minutes' => 19,
                'min_minutes' => 15,
                'avg_minutes' => 19,
                'max_minutes' => 25,
                'wait_minutes' => 3,
                'frequency_volume' => 1,
                'execution_type' => 'manual',
                'requires_human_validation' => false,
                'sequence_type' => 'secuencial',
                'evidence_generated' => 'Correo enviado y PDF',
                'problems' => 'La generación manual se repite todos los días.',
                'automatable' => 'si',
                'comments' => 'Ideal para automatización con n8n y PDF.',
            ]);

            SystemIntegration::create([
                'client_id' => $client->id,
                'process_id' => $process->id,
                'name' => 'Monday',
                'url' => 'https://demo.monday.com',
                'system_type' => 'gestión de tareas',
                'description' => 'Tableros de seguimiento comercial y operativo.',
                'has_api' => true,
                'api_available' => 'si',
                'api_type' => 'REST',
                'api_version' => 'v2',
                'documentation_url' => 'https://developers.monday.com/',
                'webhooks_available' => true,
                'known_limits' => 'Límites de rate limit por cuenta.',
                'environment' => 'produccion',
                'auth_type' => 'api key',
                'access_owner' => 'TI',
                'access_status' => 'aprobado',
                'access_status_detail' => 'Acceso disponible para pruebas.',
                'restrictions' => 'Uso controlado por TI.',
                'notes' => 'Fuente principal de seguimiento.',
            ]);

            SystemIntegration::create([
                'client_id' => $client->id,
                'process_id' => $process->id,
                'name' => 'SharePoint',
                'url' => 'https://demo.sharepoint.com',
                'system_type' => 'documental',
                'description' => 'Repositorio de evidencias y reportes.',
                'has_api' => true,
                'api_available' => 'si',
                'api_type' => 'REST',
                'api_version' => 'v1',
                'documentation_url' => 'https://learn.microsoft.com/sharepoint/dev/',
                'webhooks_available' => false,
                'known_limits' => 'Permisos heredados y estructura compleja.',
                'environment' => 'produccion',
                'auth_type' => 'microsoft 365',
                'access_owner' => 'Operaciones',
                'access_status' => 'aprobado',
                'access_status_detail' => 'Repositorio ya autorizado.',
                'restrictions' => 'Solo lectura para pruebas.',
                'notes' => 'Archivo histórico del proceso.',
            ]);

            DocumentEvidence::create([
                'process_id' => $process->id,
                'name' => 'Plantilla de reporte diario',
                'type' => 'reporte',
                'format' => 'xlsx',
                'location' => 'SharePoint / Reportes',
                'owner' => 'Laura Pérez',
                'mandatory' => true,
                'direction' => 'entrada',
                'sensitivity' => 'media',
                'retention' => '12 meses',
                'schema_summary' => 'Columnas de ventas, tareas y responsables.',
                'example_reference' => 'RPT-2026-07',
                'notes' => 'Base para el informe consolidado.',
            ]);

            DocumentEvidence::create([
                'process_id' => $process->id,
                'name' => 'Reporte PDF final',
                'type' => 'entregable',
                'format' => 'pdf',
                'location' => 'SharePoint / Históricos',
                'owner' => 'Gerencia',
                'mandatory' => true,
                'direction' => 'salida',
                'sensitivity' => 'alta',
                'retention' => '24 meses',
                'schema_summary' => 'Resumen ejecutivo y KPIs del día.',
                'example_reference' => 'PDF-REP-001',
                'notes' => 'Documento que debería automatizarse.',
            ]);

            CurrentProblem::create([
                'process_id' => $process->id,
                'description' => 'El equipo descarga manualmente información de varias plataformas y luego la pega en Excel.',
                'trigger' => 'Cierre de jornada',
                'current_action' => 'Copiar y consolidar manualmente.',
                'impact' => 'alto',
                'frequency' => 'diaria',
                'risk' => 'medio',
                'severity' => 'alta',
                'retry_possible' => true,
                'escalation_rule' => 'Escalar a jefatura si faltan datos.',
                'comments' => 'Requiere validación humana constante.',
            ]);

            CurrentProblem::create([
                'process_id' => $process->id,
                'description' => 'Los reportes cambian de formato según quién los prepare.',
                'trigger' => 'Solicitud de gerencia',
                'current_action' => 'Ajustar manualmente la plantilla.',
                'impact' => 'medio',
                'frequency' => 'semanal',
                'risk' => 'medio',
                'severity' => 'media',
                'retry_possible' => false,
                'escalation_rule' => 'Validar con operaciones antes de enviar.',
                'comments' => 'Falta estandarización.',
            ]);

            AutomationOpportunity::create([
                'process_id' => $process->id,
                'activity' => 'Generación automática de reporte diario',
                'problem' => 'Recolección y consolidación manual de datos.',
                'current_time_minutes' => 94,
                'current_time_period' => 'diario',
                'expected_time_minutes' => 10,
                'expected_time_period' => 'diario',
                'estimated_savings_minutes' => 84,
                'execution_volume' => 1,
                'monthly_savings_minutes' => 84 * 22,
                'annual_savings_minutes' => 84 * 264,
                'automation_percentage' => 90,
                'human_validation_required' => true,
                'confidence' => 82,
                'suggested_technology' => 'n8n + IA + API',
                'technologies' => ['n8n', 'IA', 'API', 'Excel'],
                'dependencies' => 'Acceso a API de Monday y SharePoint.',
                'priority' => 'alta',
                'complexity' => 3,
                'status' => 'draft',
                'notes' => 'Ahorro inicial de alto impacto.',
            ]);

            AutomationOpportunity::create([
                'process_id' => $process->id,
                'activity' => 'Validación de anomalías antes de envío',
                'problem' => 'Errores manuales al consolidar cifras.',
                'current_time_minutes' => 16,
                'current_time_period' => 'diario',
                'expected_time_minutes' => 4,
                'expected_time_period' => 'diario',
                'estimated_savings_minutes' => 12,
                'execution_volume' => 1,
                'monthly_savings_minutes' => 12 * 22,
                'annual_savings_minutes' => 12 * 264,
                'automation_percentage' => 75,
                'human_validation_required' => true,
                'confidence' => 68,
                'suggested_technology' => 'IA + OCR',
                'technologies' => ['IA', 'OCR'],
                'dependencies' => 'Formato estable del reporte.',
                'priority' => 'media',
                'complexity' => 2,
                'status' => 'draft',
                'notes' => 'Puede actuar como segundo piloto.',
            ]);

            InternalEvaluation::create([
                'process_id' => $process->id,
                'complexity' => 3,
                'risk' => 2,
                'impact' => 5,
                'confidence' => 82,
                'requires_mcp' => true,
                'requires_hermes_skill' => false,
                'requires_n8n' => true,
                'requires_ai' => true,
                'requires_ocr' => false,
                'estimated_hours' => 150,
                'integrations_required' => 'Monday, SharePoint, Outlook',
                'security_requirements' => 'API key segura y control de permisos.',
                'hours_phase_1' => 40,
                'hours_phase_2' => 55,
                'hours_phase_3' => 55,
                'responsible' => 'Consultor interno',
                'review_state' => 'draft',
                'candidate_technologies' => ['n8n', 'IA', 'API'],
                'dependencies' => 'Acceso a cuentas y aprobación operativa.',
                'technical_notes' => 'Proyecto apto para piloto con ROI claro.',
            ]);

            BacklogItem::create([
                'process_id' => $process->id,
                'epic' => 'Diagnóstico y automatización',
                'type' => 'historia de usuario',
                'title' => 'Como gerente quiero un reporte diario automático',
                'description' => 'Generar un reporte consolidado al cierre de jornada sin intervención manual.',
                'acceptance_criteria' => 'Se entrega un PDF con datos consolidados y trazables todos los días.',
                'priority' => 'alta',
                'responsible' => 'Consultor',
                'status' => 'draft',
                'estimated_hours' => 24,
                'dependencies' => 'Acceso API y plantilla estable.',
                'origin' => 'demo',
                'phase' => 'descubrimiento',
                'due_date' => now()->addDays(7),
            ]);

            BacklogItem::create([
                'process_id' => $process->id,
                'epic' => 'Integración',
                'type' => 'integración',
                'title' => 'Conectar Monday y SharePoint',
                'description' => 'Sincronizar tareas y evidencia documental.',
                'acceptance_criteria' => 'La información se lee automáticamente sin exportaciones manuales.',
                'priority' => 'media',
                'responsible' => 'Arquitecto',
                'status' => 'draft',
                'estimated_hours' => 18,
                'dependencies' => 'Credenciales y webhooks.',
                'origin' => 'demo',
                'phase' => 'construcción',
                'due_date' => now()->addDays(14),
            ]);

            ProcessStakeholder::create([
                'process_id' => $process->id,
                'name' => 'Laura Pérez',
                'position' => 'Jefa de Operaciones',
                'area' => 'Operaciones',
                'role' => 'Aprobador',
                'participation_type' => 'dueña del proceso',
                'email' => 'laura.perez@demo-automatizacion.pe',
                'phone' => '+51 999 888 777',
                'notes' => 'Valida el reporte final.',
            ]);

            ProcessStakeholder::create([
                'process_id' => $process->id,
                'name' => 'Diego Ramos',
                'position' => 'Analista BI',
                'area' => 'Datos',
                'role' => 'Soporte técnico',
                'participation_type' => 'colaborador',
                'email' => 'diego.ramos@demo-automatizacion.pe',
                'phone' => '+51 988 777 666',
                'notes' => 'Ayuda con exportaciones y validación.',
            ]);

            ProcessDependency::create([
                'process_id' => $process->id,
                'predecessor_step_id' => $step1->id,
                'successor_step_id' => $step2->id,
                'type' => 'secuencial',
                'condition' => 'La exportación debe completarse antes del cruce.',
                'notes' => 'Dependencia principal entre extracción y consolidación.',
            ]);

            ProcessDependency::create([
                'process_id' => $process->id,
                'predecessor_step_id' => $step2->id,
                'successor_step_id' => $process->steps()->orderBy('step_number')->get()->last()->id,
                'type' => 'secuencial',
                'condition' => 'La validación ocurre después de consolidar.',
                'notes' => 'Dependencia para el cierre diario.',
            ]);

            ProcessDecision::create([
                'process_id' => $process->id,
                'step_id' => $step2->id,
                'condition_evaluated' => '¿Los datos consolidados superan la validación? ',
                'decision_owner' => 'Laura Pérez',
                'true_result' => 'Se envía el reporte.',
                'false_result' => 'Se corrige el libro.',
                'evidence' => 'Checklist de validación.',
            ]);

            ProcessException::create([
                'process_id' => $process->id,
                'step_id' => $step1->id,
                'system_integration_id' => $process->systems()->first()->id,
                'trigger' => 'API caída o respuesta incompleta.',
                'current_action' => 'Descarga manual.',
                'owner' => 'TI',
                'resolution_time_minutes' => 45,
                'severity' => 'alta',
                'retry_possible' => true,
                'escalation_rule' => 'Escalar a TI si el error persiste más de 15 minutos.',
            ]);

            ProcessMetric::create([
                'process_id' => $process->id,
                'name' => 'Tiempo de consolidación',
                'min_quantity' => 85,
                'avg_quantity' => 94,
                'max_quantity' => 110,
                'unit' => 'minutos',
                'period' => 'diario',
                'source' => 'observación',
                'confirmed' => true,
            ]);

            ProcessConstraint::create([
                'process_id' => $process->id,
                'type' => 'tecnológica',
                'description' => 'Debe mantenerse SharePoint como repositorio oficial.',
                'impact' => 'alto',
                'validation_owner' => 'TI',
                'status' => 'pendiente',
            ]);

            ProcessAssumption::create([
                'process_id' => $process->id,
                'description' => 'Las credenciales de Monday y SharePoint se pueden exponer a la automatización.',
                'impact' => 'alto',
                'validation_owner' => 'TI',
                'status' => 'pendiente',
            ]);
        });
    }
}
