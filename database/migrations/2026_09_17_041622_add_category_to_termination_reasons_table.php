<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('termination_reasons', function (Blueprint $table) {
            $table->enum('category', [
                'standard_phk',
                'merger_acquisition',
                'efficiency_loss',
                'efficiency_prevention',
                'closure_loss',
                'closure_no_loss',
                'force_majeure_closure',
                'force_majeure_no_closure',
                'pkpu_loss',
                'pkpu_no_loss',
                'bankruptcy',
                'resignation',
                'absence',
                'urgent_violation',
                'sickness_disability',
                'retirement',
                'death',
            ])->default('standard_phk')->after('legal_basis');
            $table->boolean('uses_separation_money')->default(false)->after('category');
            $table->boolean('uses_pension_fund')->default(false)->after('uses_separation_money');
        });
    }

    public function down(): void
    {
        Schema::table('termination_reasons', function (Blueprint $table) {
            $table->dropColumn(['category', 'uses_separation_money', 'uses_pension_fund']);
        });
    }
};