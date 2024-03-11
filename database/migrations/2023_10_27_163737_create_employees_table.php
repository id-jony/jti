<?php

use App\Models\Department;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->uuid()->unique();
            $table->string('email')->nullable();
            $table->foreignIdFor(Department::class);
            $table->boolean('is_registered')->default(false);
            $table->timestamp('registered')->nullable();
            $table->boolean('is_passed')->default(false);
            $table->timestamp('passed')->nullable();
            $table->timestamps();
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
