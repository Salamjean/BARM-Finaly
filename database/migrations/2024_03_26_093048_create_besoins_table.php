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
        Schema::disableForeignKeyConstraints();

        Schema::create('besoins', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->enum('status', ["pending","validated","refused","partial_validated"])->default('pending');
            $table->integer('user_id')->nullable();
            $table->integer('chef_barm_id')->nullable();
            $table->integer('rh_id')->nullable();
            $table->string('commentaire')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('besoins');
    }
};
