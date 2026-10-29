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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('registration_code')->unique();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('position');
            $table->string('company_name');
            $table->string('organization_type');
            $table->string('country', 10);
            $table->string('city');
            $table->string('participation_category')->default('investor');
            $table->json('sectors')->nullable();
            $table->json('sessions')->nullable();
            $table->boolean('privacy_agreed')->default(false);
            $table->string('status', 30)->default('pending_verification');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            // Enforce duplicate policy: one registration per normalized email per event
            $table->unique(['event_id', 'email'], 'unique_event_email_registration');
            $table->index(['event_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
