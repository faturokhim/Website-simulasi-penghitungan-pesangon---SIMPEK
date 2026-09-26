<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regulations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->string('year');
            $table->string('article')->nullable();
            $table->text('description')->nullable();
            $table->string('document_path')->nullable();
            $table->string('rule_version')->nullable();
            $table->date('effective_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regulations');
    }
};