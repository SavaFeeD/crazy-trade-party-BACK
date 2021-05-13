<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('role')->default('user');
            $table->string('username');
            $table->string('role');
            $table->string('email')->unique();
            $table->string('slug')->nullable()->unique();
            $table->string('password');
            $table->string('img')->nullable();
            $table->bigInteger('crazy_coins')->default(0);
            $table->string('api_token')->nullable();
        });

        \Illuminate\Support\Facades\DB::table('users')->insert([
            'role' => 'admin',
            'username' => 'admin',
            'email' => 'admin@mail.ru',
            'slug' => 'admin',
            'password' => 'admin',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
