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
        Schema::table('talent_trainings', function (Blueprint $table) {
            Schema::table('talent_trainings', function (Blueprint $table) {
                $table->dateTime('start_at')->nullable();
                $table->string('location')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('talent_trainings', function (Blueprint $table) {
            $table->dropColumn(['start_at', 'location']);
        });
    }
};
