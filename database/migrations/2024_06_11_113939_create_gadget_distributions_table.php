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
        Schema::create('gadget_distributions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('title');
            $table->text('sub_title')->nullable();
            $table->date('distribution_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gadget_distributions');
    }
};
