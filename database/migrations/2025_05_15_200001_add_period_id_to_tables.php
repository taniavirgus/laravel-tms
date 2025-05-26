<?php

use App\Models\Period;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    $tables = [
      'employee_evaluations',
      'employee_trainings',
      'feedback'
    ];

    foreach ($tables as $table) {
      Schema::table($table, function (Blueprint $table) {
        $table->foreignIdFor(Period::class)->constrained()->cascadeOnDelete();
      });
    }
  }

  public function down()
  {
    $tables = [
      'employee_evaluations',
      'employee_trainings',
      'feedback'
    ];

    foreach ($tables as $table) {
      Schema::table($table, function (Blueprint $table) {
        $table->dropForeign(['period_id']);
        $table->dropColumn('period_id');
      });
    }
  }
};
