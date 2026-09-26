<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calculations', function (Blueprint $table) {
            if (!Schema::hasColumn('calculations', 'cuti_remaining')) {
                $table->decimal('cuti_remaining', 10, 2)->default(0)->after('termination_reason_id');
            }
            if (!Schema::hasColumn('calculations', 'other_rights')) {
                $table->decimal('other_rights', 15, 2)->default(0)->after('cuti_remaining');
            }
            if (!Schema::hasColumn('calculations', 'return_cost')) {
                $table->decimal('return_cost', 15, 2)->default(0)->after('other_rights');
            }
        });
    }

    public function down(): void
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->dropColumn(['cuti_remaining', 'other_rights', 'return_cost']);
        });
    }
};
