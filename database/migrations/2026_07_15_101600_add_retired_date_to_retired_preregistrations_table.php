<?php

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
        Schema::table('retired_preregistrations', function (Blueprint $table) {
            $table->date('retired_date')->nullable()->after('residence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retired_preregistrations', function (Blueprint $table) {
            $table->dropColumn('retired_date');
        });
    }
};
