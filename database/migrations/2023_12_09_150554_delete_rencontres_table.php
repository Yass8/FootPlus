<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('rencontres');
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('rencontres', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_rencontre');
            $table->string('lieu');
            $table->boolean('jouer')->default(0);
            $table->boolean('repporter')->default(0);
            $table->unsignedBigInteger('journee_id');
            $table->foreign('journee_id')->references('id')->on('journees')->onDelete('cascade');
            Schema::enableForeignKeyConstraints();
            $table->timestamps();
        });
    }
};
