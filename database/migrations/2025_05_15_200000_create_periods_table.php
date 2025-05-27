<?php

use App\Enums\SemesterType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * run the migration
   */
  public function up()
  {
    $semesters = SemesterType::cases();

    Schema::create('periods', function (Blueprint $table) use ($semesters) {
      $table->id();
      $table->year('year');
      $table->enum('semester', array_map(fn($semester) => $semester->value, $semesters));
      $table->timestamps();
      $table->unique(['year', 'semester']);
    });
  }

  /**
   * reverse the migration
   */
  public function down()
  {
    Schema::dropIfExists('periods');
  }
};
