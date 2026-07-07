<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('process_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->unsignedInteger('step_number');
            $table->text('description');
            $table->string('owner')->nullable();
            $table->string('system_used')->nullable();
            $table->text('input')->nullable();
            $table->text('output')->nullable();
            $table->unsignedInteger('estimated_minutes')->default(0);
            $table->text('evidence_generated')->nullable();
            $table->text('problems')->nullable();
            $table->string('automatable')->default('parcial');
            $table->text('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('process_steps');
    }
};

