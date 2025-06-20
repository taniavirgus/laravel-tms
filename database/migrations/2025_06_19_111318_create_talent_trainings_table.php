<?php

use App\Enums\SegmentType;
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
    $segements = SegmentType::cases();

    Schema::create('talent_trainings', function (Blueprint $table) use ($segements) {
      $table->id();
      $table->timestamps();
      $table->string('name');
      $table->text('description');
      $table->date('start_date');
      $table->date('end_date');
      $table->integer('duration')->default(0)->comment('duration in hours');
      $table->enum('segment', array_map(fn($segment) => $segment->value, $segements));
      $table->boolean('notified')->default(false)->comment('indicates if the participants have been notified, thus locking the training for updates');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('talent_trainings');
  }
};
