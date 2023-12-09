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
        Schema::create('homes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipe_id');
            $table->integer('buts');
            $table->unsignedBigInteger('rencontre_id');
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('cascade');
            $table->foreign('rencontre_id')->references('id')->on('rencontres')->onDelete('cascade');
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
        Schema::dropIfExists('homes');
    }
};
