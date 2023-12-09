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
        Schema::create('championnats', function (Blueprint $table) {
            $table->id();
            $table->string('nom_championnat');
            $table->unsignedBigInteger('saison_id');
            $table->unsignedBigInteger('etat_id');
            $table->unsignedBigInteger('division_id');
            $table->foreign('saison_id')->references('id')->on('saisons')->onDelete('cascade');
            $table->foreign('etat_id')->references('id')->on('etats')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
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
        Schema::dropIfExists('championnats');
    }
};
