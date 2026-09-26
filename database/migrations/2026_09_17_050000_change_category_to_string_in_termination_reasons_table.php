<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('termination_reasons', function (Blueprint $table) {
            $table->string('category', 50)->default('standard_phk')->change();
        });
    }

    public function down(): void
    {
        // Keep string for stability
    }
};

