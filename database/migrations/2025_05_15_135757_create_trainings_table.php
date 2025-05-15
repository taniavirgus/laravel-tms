<?php

use App\Models\Department;
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
    Schema::create('trainings', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->string('name');
      $table->text('description');
      $table->date('start_date');
      $table->date('end_date');
      $table->integer('duration')->default(0)->comment('Duration in hours');
      $table->integer('capacity')->default(0)->comment('Maximum number of participants');
      $table->foreignIdFor(Department::class)->constrained()->onDelete('cascade');
      $table->foreignIdFor(Evaluation::class)->constrained()->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('trainings');
  }
};
