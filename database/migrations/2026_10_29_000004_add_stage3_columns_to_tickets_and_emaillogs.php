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
        Schema::table('tickets', function (Blueprint $table) {
            $table->text('encrypted_token')->nullable()->after('qr_token');
        });

        Schema::table('email_logs', function (Blueprint $table) {
            $table->foreignId('ticket_id')->nullable()->after('registration_id')->constrained('tickets')->nullOnDelete();
            $table->unsignedSmallInteger('attempt_count')->default(1)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_logs', function (Blueprint $table) {
            $table->dropForeign(['ticket_id']);
            $table->dropColumn(['ticket_id', 'attempt_count']);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('encrypted_token');
        });
    }
};
