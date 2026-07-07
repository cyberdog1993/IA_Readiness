<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_evidences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('process_id')->constrained('processes')->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('format')->nullable();
            $table->string('location')->nullable();
            $table->string('owner')->nullable();
            $table->boolean('mandatory')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_evidences');
    }
};

