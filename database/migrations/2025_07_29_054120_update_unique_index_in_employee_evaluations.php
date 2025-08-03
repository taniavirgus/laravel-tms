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
        Schema::table('employee_evaluations', function (Blueprint $table) {
            // Drop unique lama (pakai nama index)
            $table->dropUnique('employee_evaluations_employee_id_evaluation_id_unique');

            // Tambahkan unique baru yang mencakup period_id
            $table->unique(['employee_id', 'evaluation_id', 'period_id'], 'employee_eval_emp_eval_period_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_evaluations', function (Blueprint $table) {
            $table->dropUnique('employee_eval_emp_eval_period_unique');

            $table->unique(['employee_id', 'evaluation_id'], 'employee_evaluations_employee_id_evaluation_id_unique');
        });
    }
};
