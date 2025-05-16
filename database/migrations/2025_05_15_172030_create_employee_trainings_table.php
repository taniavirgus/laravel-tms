<?php

use App\Models\Employee;
use App\Models\Training;
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
    Schema::create('employee_trainings', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->foreignIdFor(Employee::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(Training::class)->constrained()->cascadeOnDelete();
      $table->boolean('email_sent')->default(false);
      $table->integer('score')->default(0);
      $table->unique([
        'employee_id',
        'training_id'
      ]);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('employee_trainings');
  }
};
