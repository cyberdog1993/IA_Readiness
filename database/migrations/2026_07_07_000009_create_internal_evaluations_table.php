<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internal_evaluations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->unsignedTinyInteger('complexity')->default(3);
            $table->unsignedTinyInteger('risk')->default(3);
            $table->unsignedTinyInteger('impact')->default(3);
            $table->boolean('requires_mcp')->default(false);
            $table->boolean('requires_hermes_skill')->default(false);
            $table->boolean('requires_n8n')->default(false);
            $table->boolean('requires_ai')->default(false);
            $table->boolean('requires_ocr')->default(false);
            $table->unsignedInteger('estimated_hours')->default(0);
            $table->text('technical_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internal_evaluations');
    }
};

