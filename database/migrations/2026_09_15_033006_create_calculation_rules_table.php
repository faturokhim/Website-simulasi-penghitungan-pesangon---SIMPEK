<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculation_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('termination_reason_id')->nullable();
            $table->unsignedBigInteger('regulation_id')->nullable();
            $table->decimal('severance_multiplier', 5, 2)->nullable();
            $table->decimal('upmk_multiplier', 5, 2)->nullable();
            $table->text('uph_rule')->nullable();
            $table->string('rule_version')->nullable();
            $table->date('effective_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculation_rules');
    }
};