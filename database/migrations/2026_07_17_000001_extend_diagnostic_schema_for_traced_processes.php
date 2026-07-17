<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table): void {
            $table->unsignedInteger('version')->default(1)->after('maturity_score');
            $table->string('consultant_name')->nullable()->after('version');
            $table->timestamp('last_exported_at')->nullable()->after('consulting_requested_at');
            $table->string('source')->nullable()->after('status');
        });

        Schema::table('processes', function (Blueprint $table): void {
            $table->unsignedInteger('version')->default(1)->after('status');
            $table->string('state')->default('borrador')->after('version');
            $table->string('consultant_name')->nullable()->after('state');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('consultant_name');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->after('created_by');
            $table->timestamp('validated_at')->nullable()->after('updated_by');
            $table->timestamp('last_exported_at')->nullable()->after('validated_at');
            $table->string('priority')->nullable()->after('last_exported_at');
            $table->text('secondary_objectives')->nullable()->after('objective');
            $table->text('business_problems')->nullable()->after('secondary_objectives');
            $table->text('completion_criteria')->nullable()->after('business_problems');
            $table->text('start_event')->nullable()->after('trigger_event');
            $table->text('end_event')->nullable()->after('start_event');
            $table->unsignedInteger('frequency_number')->nullable()->after('frequency');
            $table->string('frequency_period')->nullable()->after('frequency_number');
            $table->text('context_for_ai')->nullable()->after('frequency_period');
            $table->string('category')->nullable()->after('context_for_ai');
            $table->string('sector')->nullable()->after('category');
            $table->json('tags')->nullable()->after('sector');
            $table->foreignUuid('template_process_id')->nullable()->constrained('processes')->nullOnDelete()->after('tags');
            $table->text('notes')->nullable()->after('template_process_id');
        });

        Schema::table('process_steps', function (Blueprint $table): void {
            $table->string('title')->nullable()->after('step_number');
            $table->unsignedInteger('min_minutes')->nullable()->after('description');
            $table->unsignedInteger('avg_minutes')->nullable()->after('min_minutes');
            $table->unsignedInteger('max_minutes')->nullable()->after('avg_minutes');
            $table->unsignedInteger('wait_minutes')->nullable()->after('max_minutes');
            $table->unsignedInteger('frequency_volume')->nullable()->after('wait_minutes');
            $table->string('execution_type')->default('manual')->after('frequency_volume');
            $table->boolean('requires_human_validation')->default(false)->after('execution_type');
            $table->string('sequence_type')->nullable()->after('requires_human_validation');
        });

        Schema::table('system_integrations', function (Blueprint $table): void {
            $table->text('description')->nullable()->after('name');
            $table->string('api_available')->nullable()->after('description');
            $table->string('api_type')->nullable()->after('api_available');
            $table->string('api_version')->nullable()->after('api_type');
            $table->string('documentation_url')->nullable()->after('api_version');
            $table->boolean('webhooks_available')->default(false)->after('documentation_url');
            $table->text('known_limits')->nullable()->after('webhooks_available');
            $table->string('environment')->nullable()->after('known_limits');
            $table->text('access_status_detail')->nullable()->after('environment');
            $table->text('restrictions')->nullable()->after('access_status_detail');
        });

        Schema::table('document_evidences', function (Blueprint $table): void {
            $table->string('direction')->nullable()->after('name');
            $table->string('sensitivity')->nullable()->after('direction');
            $table->string('retention')->nullable()->after('sensitivity');
            $table->text('schema_summary')->nullable()->after('retention');
            $table->string('example_reference')->nullable()->after('schema_summary');
        });

        Schema::table('current_problems', function (Blueprint $table): void {
            $table->text('trigger')->nullable()->after('description');
            $table->text('current_action')->nullable()->after('trigger');
            $table->unsignedInteger('resolution_time_minutes')->nullable()->after('current_action');
            $table->string('severity')->nullable()->after('resolution_time_minutes');
            $table->boolean('retry_possible')->default(false)->after('severity');
            $table->text('escalation_rule')->nullable()->after('retry_possible');
        });

        Schema::table('automation_opportunities', function (Blueprint $table): void {
            $table->text('problem')->nullable()->after('activity');
            $table->string('current_time_period')->nullable()->after('problem');
            $table->string('expected_time_period')->nullable()->after('current_time_period');
            $table->unsignedInteger('execution_volume')->nullable()->after('expected_time_period');
            $table->unsignedInteger('monthly_savings_minutes')->nullable()->after('execution_volume');
            $table->unsignedInteger('annual_savings_minutes')->nullable()->after('monthly_savings_minutes');
            $table->unsignedTinyInteger('automation_percentage')->nullable()->after('annual_savings_minutes');
            $table->boolean('human_validation_required')->default(false)->after('automation_percentage');
            $table->unsignedTinyInteger('confidence')->nullable()->after('human_validation_required');
            $table->json('technologies')->nullable()->after('confidence');
            $table->text('dependencies')->nullable()->after('technologies');
        });

        Schema::table('internal_evaluations', function (Blueprint $table): void {
            $table->unsignedTinyInteger('confidence')->nullable()->after('impact');
            $table->text('integrations_required')->nullable()->after('confidence');
            $table->text('security_requirements')->nullable()->after('integrations_required');
            $table->unsignedInteger('hours_phase_1')->nullable()->after('estimated_hours');
            $table->unsignedInteger('hours_phase_2')->nullable()->after('hours_phase_1');
            $table->unsignedInteger('hours_phase_3')->nullable()->after('hours_phase_2');
            $table->string('responsible')->nullable()->after('hours_phase_3');
            $table->string('review_state')->default('draft')->after('responsible');
            $table->json('candidate_technologies')->nullable()->after('review_state');
            $table->text('dependencies')->nullable()->after('candidate_technologies');
        });

        Schema::table('backlog_items', function (Blueprint $table): void {
            $table->string('epic')->nullable()->after('process_id');
            $table->text('dependencies')->nullable()->after('estimated_hours');
            $table->string('origin')->default('manual')->after('dependencies');
            $table->string('phase')->nullable()->after('origin');
            $table->date('due_date')->nullable()->after('phase');
        });

        Schema::create('process_stakeholders', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('area')->nullable();
            $table->string('role')->nullable();
            $table->string('participation_type')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('process_dependencies', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->foreignUuid('predecessor_step_id')->constrained('process_steps')->cascadeOnDelete();
            $table->foreignUuid('successor_step_id')->constrained('process_steps')->cascadeOnDelete();
            $table->string('type')->default('secuencial');
            $table->text('condition')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('process_decisions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->foreignUuid('step_id')->nullable()->constrained('process_steps')->nullOnDelete();
            $table->text('condition_evaluated')->nullable();
            $table->string('decision_owner')->nullable();
            $table->text('true_result')->nullable();
            $table->text('false_result')->nullable();
            $table->text('evidence')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('process_exceptions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->foreignUuid('step_id')->nullable()->constrained('process_steps')->nullOnDelete();
            $table->foreignUuid('system_integration_id')->nullable()->constrained('system_integrations')->nullOnDelete();
            $table->text('trigger')->nullable();
            $table->text('current_action')->nullable();
            $table->string('owner')->nullable();
            $table->unsignedInteger('resolution_time_minutes')->nullable();
            $table->string('severity')->nullable();
            $table->boolean('retry_possible')->default(false);
            $table->text('escalation_rule')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('process_metrics', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('min_quantity')->nullable();
            $table->unsignedInteger('avg_quantity')->nullable();
            $table->unsignedInteger('max_quantity')->nullable();
            $table->string('unit')->nullable();
            $table->string('period')->nullable();
            $table->string('source')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('process_constraints', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->string('type');
            $table->text('description');
            $table->string('impact')->nullable();
            $table->string('validation_owner')->nullable();
            $table->string('status')->default('pendiente');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('process_assumptions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->text('description');
            $table->string('impact')->nullable();
            $table->string('validation_owner')->nullable();
            $table->string('status')->default('pendiente');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('process_assumptions');
        Schema::dropIfExists('process_constraints');
        Schema::dropIfExists('process_metrics');
        Schema::dropIfExists('process_exceptions');
        Schema::dropIfExists('process_decisions');
        Schema::dropIfExists('process_dependencies');
        Schema::dropIfExists('process_stakeholders');

        Schema::table('backlog_items', function (Blueprint $table): void {
            $table->dropColumn(['epic', 'dependencies', 'origin', 'phase', 'due_date']);
        });

        Schema::table('internal_evaluations', function (Blueprint $table): void {
            $table->dropColumn([
                'confidence',
                'integrations_required',
                'security_requirements',
                'hours_phase_1',
                'hours_phase_2',
                'hours_phase_3',
                'responsible',
                'review_state',
                'candidate_technologies',
                'dependencies',
            ]);
        });

        Schema::table('automation_opportunities', function (Blueprint $table): void {
            $table->dropColumn([
                'problem',
                'current_time_period',
                'expected_time_period',
                'execution_volume',
                'monthly_savings_minutes',
                'annual_savings_minutes',
                'automation_percentage',
                'human_validation_required',
                'confidence',
                'technologies',
                'dependencies',
            ]);
        });

        Schema::table('current_problems', function (Blueprint $table): void {
            $table->dropColumn([
                'trigger',
                'current_action',
                'resolution_time_minutes',
                'severity',
                'retry_possible',
                'escalation_rule',
            ]);
        });

        Schema::table('document_evidences', function (Blueprint $table): void {
            $table->dropColumn(['direction', 'sensitivity', 'retention', 'schema_summary', 'example_reference']);
        });

        Schema::table('system_integrations', function (Blueprint $table): void {
            $table->dropColumn([
                'description',
                'api_available',
                'api_type',
                'api_version',
                'documentation_url',
                'webhooks_available',
                'known_limits',
                'environment',
                'access_status_detail',
                'restrictions',
            ]);
        });

        Schema::table('process_steps', function (Blueprint $table): void {
            $table->dropColumn([
                'title',
                'min_minutes',
                'avg_minutes',
                'max_minutes',
                'wait_minutes',
                'frequency_volume',
                'execution_type',
                'requires_human_validation',
                'sequence_type',
            ]);
        });

        Schema::table('processes', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('updated_by');
            $table->dropConstrainedForeignId('template_process_id');
            $table->dropColumn([
                'version',
                'state',
                'consultant_name',
                'validated_at',
                'last_exported_at',
                'priority',
                'secondary_objectives',
                'business_problems',
                'completion_criteria',
                'start_event',
                'end_event',
                'frequency_number',
                'frequency_period',
                'context_for_ai',
                'category',
                'sector',
                'tags',
                'notes',
            ]);
        });

        Schema::table('leads', function (Blueprint $table): void {
            $table->dropColumn(['version', 'consultant_name', 'last_exported_at', 'source']);
        });
    }
};
