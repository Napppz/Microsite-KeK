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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->string('ticket_number')->unique();
            $table->string('qr_token', 64)->unique();
            $table->string('status', 30)->default('issued');
            $table->timestamp('issued_at')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'registration_id']);
        });

        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->foreignId('ticket_id')->nullable()->constrained('tickets')->nullOnDelete();
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('checked_in_at');
            $table->string('check_in_method', 30)->default('qr_scanner');
            $table->string('gate_or_hall', 50)->nullable();
            $table->timestamps();

            // At most one successful check-in per event per registration
            $table->unique(['event_id', 'registration_id'], 'unique_event_registration_checkin');
        });

        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->nullable()->constrained('registrations')->nullOnDelete();
            $table->string('recipient_email');
            $table->string('email_type', 50);
            $table->string('status', 30)->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['registration_id', 'email_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
        Schema::dropIfExists('check_ins');
        Schema::dropIfExists('tickets');
    }
};
