<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_rewards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('reward');
            $table->integer('subject_id');
            $table->integer('goal_id');
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
        Schema::drop('users_rewards');
    }
}
