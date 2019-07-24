<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('password');
        });
        DB::table('admins')->insert(
            array(
                'user_id' => 1,
                'password' => bcrypt('strong_secret_password'),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
