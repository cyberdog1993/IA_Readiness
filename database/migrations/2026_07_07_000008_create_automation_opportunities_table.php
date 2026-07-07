<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('automation_opportunities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->string('activity');
            $table->unsignedInteger('current_time_minutes')->default(0);
            $table->unsignedInteger('expected_time_minutes')->default(0);
            $table->unsignedInteger('estimated_savings_minutes')->default(0);
            $table->string('suggested_technology')->nullable();
            $table->string('priority')->default('media');
            $table->unsignedTinyInteger('complexity')->default(3);
            $table->string('status')->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('automation_opportunities');
    }
};

