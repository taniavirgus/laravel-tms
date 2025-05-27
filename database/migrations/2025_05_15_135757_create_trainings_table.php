<?php

use App\Enums\TrainingType;
use App\Enums\AssignmentType;
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
    $trainings = TrainingType::cases();
    $assignments = AssignmentType::cases();

    Schema::create('trainings', function (Blueprint $table) use ($trainings, $assignments) {
      $table->id();
      $table->timestamps();
      $table->string('name');
      $table->text('description');
      $table->date('start_date');
      $table->date('end_date');
      $table->enum('type', array_map(fn($training) => $training->value, $trainings))->default(TrainingType::MANDATORY->value);
      $table->enum('assignment', array_map(fn($assignment) => $assignment->value, $assignments))->default(AssignmentType::OPEN->value);
      $table->integer('duration')->default(0)->comment('duration in hours');
      $table->integer('capacity')->default(0)->comment('maximum number of participants');
      $table->boolean('notified')->default(false)->comment('indicates if the participants have been notified, thus locking the training for updates');
      $table->foreignIdFor(Evaluation::class)->nullable()->constrained()->cascadeOnDelete();
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
