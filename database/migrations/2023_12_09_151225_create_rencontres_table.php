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
        Schema::create('rencontres', function (Blueprint $table) {
            $table->id();
            $table->date('date_ren');
            $table->string('lieu');
            $table->time('heure_ren');
            $table->boolean('jouer')->default(0);
            $table->boolean('repporter')->default(0);

            $table->unsignedBigInteger('journee_id');
            $table->foreign('journee_id')->references('id')->on('journees')->onDelete('cascade');
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
        Schema::dropIfExists('rencontres');
    }
};
