<?php

use App\Models\Topic;
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
    Schema::table('evaluations', function (Blueprint $table) {
      $table->foreignIdFor(Topic::class)->constrained()->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('evaluations', function (Blueprint $table) {
      $table->dropForeign(['topic_id']);
      $table->dropColumn('topic_id');
    });
  }
};
