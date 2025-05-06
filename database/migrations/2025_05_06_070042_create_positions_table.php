<?php

use App\Enums\LevelType;
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
    $levels = LevelType::cases();

    Schema::create('positions', function (Blueprint $table) use ($levels) {
      $table->id();
      $table->timestamps();
      $table->string('name');
      $table->text('description');
      $table->enum('level', array_map(fn($level) => $level->value, $levels))->default('beginner');
      $table->json('requirements');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('positions');
  }
};
