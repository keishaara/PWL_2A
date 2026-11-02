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
            if (!Schema::hasColumn('tickets', 'registration_id')) {
                $table->foreignId('registration_id')->nullable()->constrained('registrations')->onDelete('cascade');
            }
            if (!Schema::hasColumn('tickets', 'ticket_code')) {
                $table->string('ticket_code')->nullable()->unique();
            }
            if (!Schema::hasColumn('tickets', 'status')) {
                $table->enum('status', ['unused', 'used'])->default('unused');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
        });
    }
};
