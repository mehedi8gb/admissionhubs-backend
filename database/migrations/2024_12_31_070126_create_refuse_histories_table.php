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
        Schema::create('refusals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Reference to users table
            $table->string('refusal_type');    // Type of refusal
            $table->date('refusal_date');      // Date of refusal
            $table->text('details');           // Details of the refusal
            $table->string('country');         // Country related to the refusal
            $table->string('visa_type');       // Visa type related to the refusal
            $table->string('status');          // Status of the refusal (e.g., Resolved)
            $table->timestamps();              // Laravel's created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refuse_histories');
    }
};
