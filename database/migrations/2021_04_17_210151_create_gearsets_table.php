<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGearsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gearsets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('gearset_title')->nullable();
            $table->text('gearset_desc')->nullable();
            $table->boolean('gearset_mode_rm')->nullable();
            $table->boolean('gearset_mode_cb')->nullable();
            $table->boolean('gearset_mode_sz')->nullable();
            $table->boolean('gearset_mode_tc')->nullable();
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
        Schema::dropIfExists('gearsets');
    }
}
