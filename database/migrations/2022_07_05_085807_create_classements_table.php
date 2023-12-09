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
        Schema::create('classements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('championnat_id');
            $table->unsignedBigInteger('equipe_id');
            $table->integer('MJ')->default(0);
            $table->integer('MG')->default(0);
            $table->integer('MN')->default(0);
            $table->integer('MP')->default(0);
            $table->integer('BM')->default(0);
            $table->integer('BE')->default(0);
            $table->integer('DF')->default(0);
            $table->integer('Pts')->default(0);
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('cascade');
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
        Schema::dropIfExists('classements');
    }
};
