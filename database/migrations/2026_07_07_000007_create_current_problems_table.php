<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('current_problems', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->text('description');
            $table->string('impact')->nullable();
            $table->string('frequency')->nullable();
            $table->string('risk')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('current_problems');
    }
};

