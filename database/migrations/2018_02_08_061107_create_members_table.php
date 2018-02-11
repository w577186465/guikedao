<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->unique();
            $table->string('avatar')->default('');
            $table->string('name')->index()->default('');
            $table->integer('sex')->index()->default(0);
            $table->integer('tel')->index()->default(0);
            $table->integer('region')->index()->default(0);
            $table->string('adress')->default('');
            $table->string('certnumber')->index()->default('');
            $table->integer('status')->index()->default(0); // 0普通会员 1高级会员 2审核中 -1 审核驳回
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
        Schema::dropIfExists('members');
    }
}
