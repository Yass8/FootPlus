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
            $table->string('home')->default('')->after('id');
            $table->string('visit')->default('')->after('home');
            $table->integer('buts_home')->after('visit')->default(0);
            $table->integer('buts_visit')->after('buts_home')->default(0);
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
            $table->dropColumn('home');
            $table->dropColumn('visit');
            $table->dropColumn('buts_home');
            $table->dropColumn('buts_visit');
        });
    }
};
