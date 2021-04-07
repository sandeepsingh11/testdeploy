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
            $table->text('gear_id');
            $table->smallInteger('gear_main')->nullable();
            $table->smallInteger('gear_sub_1')->nullable();
            $table->smallInteger('gear_sub_2')->nullable();
            $table->smallInteger('gear_sub_3')->nullable();
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
