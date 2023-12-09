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
        Schema::dropIfExists('parametres');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('parametres', function (Blueprint $table) {
            $table->id();
            $table->boolean('officiel')->default(0);
            $table->integer('nombre_equipes_montes')->default(2);
            $table->integer('position_descente')->default(9);
            $table->unsignedBigInteger('championnat_id');
            $table->foreign('championnat_id')->references('id')->on('championnats')->onDelete('cascade');
            Schema::enableForeignKeyConstraints();
            $table->timestamps();
        });
    }
};
