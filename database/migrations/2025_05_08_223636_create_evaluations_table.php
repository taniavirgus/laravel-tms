<?php

use App\Enums\ApprovalType;
use App\Models\Department;
use App\Models\Position;
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
    $approvals = ApprovalType::cases();

    Schema::create('evaluations', function (Blueprint $table) use ($approvals) {
      $table->id();
      $table->timestamps();
      $table->string('name');
      $table->text('description');
      $table->integer('point')->default(0);
      $table->integer('target')->default(0);
      $table->enum('status', array_map(fn($type) => $type->value, $approvals))->default(ApprovalType::DRAFT->value);
      $table->foreignIdFor(Department::class)->constrained()->cascadeOnDelete();
      $table->foreignIdFor(Position::class)->constrained()->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('evaluations');
  }
};
