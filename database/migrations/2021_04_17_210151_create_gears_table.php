<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gears', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('gear_name')->nullable();
            $table->text('gear_desc')->nullable();
            $table->boolean('gear_mode_rm')->nullable();
            $table->boolean('gear_mode_cb')->nullable();
            $table->boolean('gear_mode_sz')->nullable();
            $table->boolean('gear_mode_tc')->nullable();
            $table->integer('gear_weapon_id')->nullable();
            $table->integer('gear_piece_h_id')->nullable();
            $table->integer('gear_piece_c_id')->nullable();
            $table->integer('gear_piece_s_id')->nullable();
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
        Schema::dropIfExists('gears');
    }
}
