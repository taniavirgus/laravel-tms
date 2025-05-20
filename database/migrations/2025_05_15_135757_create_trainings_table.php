<?php

use App\Enums\TrainingType;
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
    $trainings = TrainingType::cases();

    Schema::create('trainings', function (Blueprint $table) use ($trainings) {
      $table->id();
      $table->timestamps();
      $table->string('name');
      $table->text('description');
      $table->date('start_date');
      $table->date('end_date');
      $table->enum('type', array_map(fn($training) => $training->value, $trainings))->default(TrainingType::MANDATORY->value);
      $table->integer('duration')->default(0)->comment('Duration in hours');
      $table->integer('capacity')->default(0)->comment('Maximum number of participants');
      $table->boolean('notified')->default(false)->comment('Indicates if the participants have been notified, thus locking the training for updates');
      $table->foreignIdFor(Department::class)->constrained()->cascadeOnDelete();
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
