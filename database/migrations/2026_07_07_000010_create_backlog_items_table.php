<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backlog_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->string('type');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('acceptance_criteria')->nullable();
            $table->string('priority')->default('media');
            $table->string('responsible')->nullable();
            $table->string('status')->default('draft');
            $table->unsignedInteger('estimated_hours')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backlog_items');
    }
};

