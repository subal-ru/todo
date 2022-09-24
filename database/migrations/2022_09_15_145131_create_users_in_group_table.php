<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_in_group', function (Blueprint $table) {
            // $table->id();
            $table->integer('group_id'); //グループid
            $table->bigInteger('user_id'); //ユーザーid
            $table->integer('authority')->nullable(); //権限もちかどうか 1:管理者(最上位を除く)
            $table->string('color')->default('#999999');
            $table->integer('status')->default(0); //ステータス 0:通常 9:論理削除
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

            $table->primary(['group_id', 'user_id'])->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_in_group');
    }
};
