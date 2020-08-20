<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriberGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriber_groups', function (Blueprint $table) {
            $table->increments('id');
            //group_id needs to be string because of MYSQL integer range
            $table->string('group_id');
            $table->string('title');
            $table->string('type');
            $table->timestamp('last_active');
            $table->timestamps();

            $table->unique('group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriber_groups');
    }
}
