<?php

use App\Models\Employee;
use App\Models\TalentTraining;
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
    Schema::create('employee_talent_trainings', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->foreignIdFor(Employee::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(TalentTraining::class)->constrained()->cascadeOnDelete();
      $table->boolean('email_sent')->default(false);
      $table->integer('score')->default(0);
      $table->text('notes')->nullable();
      $table->unique([
        'employee_id',
        'talent_training_id'
      ]);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('employee_talent_trainings');
  }
};
