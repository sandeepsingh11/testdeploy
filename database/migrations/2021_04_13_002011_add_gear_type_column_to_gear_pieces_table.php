<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGearTypeColumnToGearPiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gear_pieces', function (Blueprint $table) {
            $table->char('gear_piece_type', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gear_pieces', function (Blueprint $table) {
            $table->dropColumn('gear_piece_type');
        });
    }
}
