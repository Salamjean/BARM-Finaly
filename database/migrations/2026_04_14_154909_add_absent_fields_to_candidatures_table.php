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
        Schema::table('candidatures', function (Blueprint $table) {
            $table->enum('absent', ['0', '1'])->default('0')->after('resignation_justification');
            $table->date('absent_date')->nullable()->after('absent');
            $table->text('absent_justification')->nullable()->after('absent_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidatures', function (Blueprint $table) {
            $table->dropColumn(['absent', 'absent_date', 'absent_justification']);
        });
    }
};
