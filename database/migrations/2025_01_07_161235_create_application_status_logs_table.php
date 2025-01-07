<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('application_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade'); // Foreign key to Application
            $table->string('prev_status')->nullable(); // Previous status
            $table->string('assigned_by'); // Who assigned the previous status
            $table->timestamp('assigned_at'); // When the previous status was assigned
            $table->string('changed_to'); // New status
            $table->string('changed_by'); // Who changed the status
            $table->timestamp('changed_at'); // When the status was changed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_status_logs');
    }
};
