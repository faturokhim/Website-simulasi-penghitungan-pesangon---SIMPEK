<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calculation_rules', function (Blueprint $table) {
            $table->decimal('separation_money_multiplier', 5, 2)->nullable()->after('uph_rule');
            $table->decimal('pension_fund_deduction', 15, 2)->nullable()->after('separation_money_multiplier');
            $table->text('special_notes')->nullable()->after('pension_fund_deduction');
        });
    }

    public function down(): void
    {
        Schema::table('calculation_rules', function (Blueprint $table) {
            $table->dropColumn(['separation_money_multiplier', 'pension_fund_deduction', 'special_notes']);
        });
    }
};