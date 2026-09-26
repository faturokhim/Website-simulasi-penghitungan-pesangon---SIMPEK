<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->decimal('daily_wage', 15, 2)->nullable()->after('non_fixed_allowance');
            $table->decimal('piece_rate_avg', 15, 2)->nullable()->after('daily_wage');
            $table->decimal('minimum_wage', 15, 2)->nullable()->after('piece_rate_avg');
            $table->decimal('user_separation_money', 15, 2)->default(0)->after('user_uph_amount');
            $table->decimal('user_pension_fund_deduction', 15, 2)->default(0)->after('user_separation_money');
            $table->decimal('admin_separation_money', 15, 2)->default(0)->after('admin_uph_amount');
            $table->decimal('admin_pension_fund_deduction', 15, 2)->default(0)->after('admin_separation_money');
            $table->string('calculation_type')->nullable()->after('regulation_id');
        });
    }

    public function down(): void
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->dropColumn([
                'daily_wage', 'piece_rate_avg', 'minimum_wage',
                'user_separation_money', 'user_pension_fund_deduction',
                'admin_separation_money', 'admin_pension_fund_deduction',
                'calculation_type',
            ]);
        });
    }
};