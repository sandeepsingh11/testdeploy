<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGearPiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gear_pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('gear_piece_name')->nullable();
            $table->text('gear_piece_desc')->nullable();
            $table->text('gear_piece_id');
            $table->char('gear_piece_type', 1);
            $table->smallInteger('gear_piece_main')->nullable();
            $table->smallInteger('gear_piece_sub_1')->nullable();
            $table->smallInteger('gear_piece_sub_2')->nullable();
            $table->smallInteger('gear_piece_sub_3')->nullable();
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
        Schema::dropIfExists('gear_pieces');
    }
}
