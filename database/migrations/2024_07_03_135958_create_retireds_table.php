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
        Schema::create('retireds', function (Blueprint $table) {
            $table->id();
            $table->integer('personal_id');
            $table->year('year');
            $table->string('grade')->nullable();
            $table->string('mecano')->unique();
            $table->string('matricule')->unique()->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->date('birth_date');
            $table->enum('gender', ['F', 'M', 'A']);
            $table->string('unit')->nullable();
            $table->string('army')->nullable();
            $table->date('retired_date');
            $table->string('retired_type');
            $table->boolean('used')->default(false);
            $table->boolean('forced_authorization')->default(false);
            $table->string('file_authorization')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retireds');
    }
};
