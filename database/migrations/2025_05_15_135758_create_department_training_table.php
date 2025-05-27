<?php

use App\Models\Department;
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
    Schema::create('department_training', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Department::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(Training::class)->constrained()->cascadeOnDelete();
      $table->timestamps();

      $table->unique(['department_id', 'training_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('department_training');
  }
};
