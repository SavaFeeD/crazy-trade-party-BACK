<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_description')->default('');
            $table->text('description')->default('');
            $table->integer('price')->default(0);
            $table->integer('views_count')->default(0);
            $table->string('img')->nullable();
            $table->string('dataset')->default('http://127.0.0.1:8000/storage/upload/nQuQCMUCHpjt0KXl3yLXWEjzBZew7DfrBT8kLPLR.csv');
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
        Schema::dropIfExists('products');
    }
}
