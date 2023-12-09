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
        Schema::create('equipes', function (Blueprint $table) {
            $table->id();
            $table->string('nom_equipe');
            $table->string('abreviation');
            $table->unsignedBigInteger('championnat_id');
            $table->foreign('championnat_id')->references('id')->on('championnats')->onDelete('cascade');
            Schema::enableForeignKeyConstraints();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipes');
    }
};
