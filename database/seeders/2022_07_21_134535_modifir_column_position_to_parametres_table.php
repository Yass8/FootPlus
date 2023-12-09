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
        Schema::table('parametres', function (Blueprint $table) {
            $table->dropColumn('nombre_equipes_relegues');
            $table->integer('position_descente')->default(9)->after('nombre_equipes_montes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parametres', function (Blueprint $table) {
            $table->integer('nombre_equipes_relegues')->default(3);
            $table->dropColumn('position_descente');
        });
    }
};
