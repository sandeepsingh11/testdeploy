<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGearSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gear_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gear_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained();
            $table->char('skill_type', 4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gear_skill');
    }
}
