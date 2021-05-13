<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        \Illuminate\Support\Facades\DB::table('categories')->insert([
            'name' => 'NLP',
        ]);

        \Illuminate\Support\Facades\DB::table('categories')->insert([
            'name' => 'Regression',
        ]);

        \Illuminate\Support\Facades\DB::table('categories')->insert([
            'name' => 'Classification',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
