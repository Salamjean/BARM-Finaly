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
            $table->string('phone2')->nullable()->after('phone');
            $table->string('residence')->nullable()->after('phone2');
            $table->dropColumn(['email', 'message']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retired_preregistrations', function (Blueprint $table) {
            $table->dropColumn(['phone2', 'residence']);
            $table->string('email')->nullable();
            $table->text('message')->nullable();
        });
    }
};
