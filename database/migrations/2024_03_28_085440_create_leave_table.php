<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('personnel_id');
            $table->enum('leave_type', ['Permission', 'Congé']);
            $table->date('leavefrom');
            $table->date('leaveto');
            $table->integer('nb_day');
            $table->date('returndate');
            $table->text('reason');
            $table->string('file')->nullable();
            $table->string('status')->default('En attente');
            $table->string('comment')->nullable();
            $table->date('approval_date')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('personnel_id')->references('id')->on('personnels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave');
    }
};
