<?php

use App\Enums\GenderType;
use App\Enums\ReligionType;
use App\Enums\StatusType;
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
    $statuses = StatusType::cases();
    $genders = GenderType::cases();
    $religions = ReligionType::cases();

    Schema::create('employees', function (Blueprint $table) use ($statuses, $genders, $religions) {
      $table->id();
      $table->timestamps();
      $table->string('name');
      $table->string('email')->unique();
      $table->string('phone');
      $table->text('address');
      $table->date('birthdate');
      $table->enum('gender', array_map(fn($gender) => $gender->value, $genders));
      $table->enum('religion', array_map(fn($religion) => $religion->value, $religions));
      $table->enum('status', array_map(fn($status) => $status->value, $statuses))->default(StatusType::ACTIVE->value);
      $table->foreignIdFor(Department::class)->constrained()->onDelete('cascade');
      $table->foreignIdFor(Position::class)->constrained()->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('employees');
  }
};
