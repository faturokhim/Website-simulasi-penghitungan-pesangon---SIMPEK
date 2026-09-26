<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('employee_name');
            $table->date('start_date');
            $table->date('termination_date');
            $table->string('identity_number')->nullable();
            $table->string('position')->nullable();
            $table->decimal('basic_salary', 15, 2)->default(0);
            $table->decimal('fixed_allowance', 15, 2)->default(0);
            $table->decimal('non_fixed_allowance', 15, 2)->default(0);
            $table->decimal('wage_basis', 15, 2)->default(0);
            $table->unsignedBigInteger('termination_reason_id')->nullable();
            $table->integer('work_years')->default(0);
            $table->integer('work_months')->default(0);
            $table->integer('work_days')->default(0);
            $table->decimal('user_severance_amount', 15, 2)->default(0);
            $table->decimal('user_upmk_amount', 15, 2)->default(0);
            $table->decimal('user_uph_amount', 15, 2)->default(0);
            $table->decimal('user_total_amount', 15, 2)->default(0);
            $table->decimal('admin_severance_amount', 15, 2)->default(0);
            $table->decimal('admin_upmk_amount', 15, 2)->default(0);
            $table->decimal('admin_uph_amount', 15, 2)->default(0);
            $table->decimal('admin_total_amount', 15, 2)->default(0);
            $table->text('admin_note')->nullable();
            $table->string('status')->default('SIMULASI');
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('rule_version')->nullable();
            $table->unsignedBigInteger('regulation_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculations');
    }
};