<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_integrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignUuid('process_id')->nullable()->constrained('processes')->nullOnDelete();
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('system_type')->nullable();
            $table->boolean('has_api')->default(false);
            $table->string('auth_type')->nullable();
            $table->string('access_owner')->nullable();
            $table->string('access_status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_integrations');
    }
};

