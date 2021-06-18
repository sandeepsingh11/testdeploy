<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToGearsets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gearsets', function (Blueprint $table) {
            $table->foreignId('weapon_id')->after('gearset_mode_tc')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gearsets', function (Blueprint $table) {
            $table->dropColumn('weapon_id');
        });
    }
}
