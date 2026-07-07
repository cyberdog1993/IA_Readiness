<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('company_name');
            $table->string('ruc', 20)->index();
            $table->string('industry');
            $table->string('contact_name');
            $table->string('contact_role');
            $table->string('email');
            $table->string('phone', 30);
            $table->string('company_size');
            $table->unsignedInteger('repetitive_process_count')->default(0);
            $table->unsignedInteger('manual_hours_weekly')->default(0);
            $table->unsignedInteger('process_documentation_level')->default(0);
            $table->unsignedInteger('digital_system_usage')->default(0);
            $table->unsignedInteger('excel_dependency')->default(0);
            $table->unsignedInteger('system_integration_level')->default(0);
            $table->unsignedInteger('manual_report_generation')->default(0);
            $table->boolean('has_kpis')->default(false);
            $table->unsignedInteger('key_person_dependency')->default(0);
            $table->unsignedInteger('automation_interest')->default(0);
            $table->unsignedTinyInteger('maturity_score')->default(0);
            $table->string('maturity_level')->nullable();
            $table->text('diagnosis_brief')->nullable();
            $table->text('opportunities_summary')->nullable();
            $table->text('recommendation')->nullable();
            $table->timestamp('consulting_requested_at')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

