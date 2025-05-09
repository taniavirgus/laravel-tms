<?php

use App\Models\Employee;
use App\Models\Evaluation;
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
    Schema::create('employee_evaluations', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->foreignIdFor(Employee::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(Evaluation::class)->constrained()->cascadeOnDelete();
      $table->unique(['employee_id', 'evaluation_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('employee_evaluations');
  }
};
