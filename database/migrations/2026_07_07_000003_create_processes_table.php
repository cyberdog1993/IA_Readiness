<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('lead_id')->nullable()->constrained('leads')->nullOnDelete();
            $table->foreignUuid('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->string('name');
            $table->string('area')->nullable();
            $table->string('owner')->nullable();
            $table->string('frequency')->nullable();
            $table->text('objective')->nullable();
            $table->text('expected_result')->nullable();
            $table->text('trigger_event')->nullable();
            $table->text('validation_method')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};

