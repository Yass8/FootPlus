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
        Schema::table('rencontres', function (Blueprint $table) {
            $table->dropColumn('date_rencontre');
            $table->date('date_ren')->after('buts_visit');
            $table->time('heure_ren')->after('date_ren');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->dateTime('date_rencontre');
            $table->dropColumn('date_ren');
            $table->dropColumn('heure_ren');
        });
    }
};
