<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFksToGears extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gears', function (Blueprint $table) {
            $table->foreignId('base_gear_id')->after('gear_title')->constrained('base_gears')->onDelete('cascade');
            $table->foreignId('main_skill_id')->after('base_gear_id')->nullable()->constrained('skills')->onDelete('cascade');
            $table->foreignId('sub_1_skill_id')->after('main_skill_id')->nullable()->constrained('skills')->onDelete('cascade');
            $table->foreignId('sub_2_skill_id')->after('sub_1_skill_id')->nullable()->constrained('skills')->onDelete('cascade');
            $table->foreignId('sub_3_skill_id')->after('sub_2_skill_id')->nullable()->constrained('skills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gears', function (Blueprint $table) {
            $table->dropColumn([
                'base_gear_id', 
                'main_skill_id', 
                'sub_1_skill_id',
                'sub_2_skill_id',
                'sub_3_skill_id',
            ]);
        });
    }
}
