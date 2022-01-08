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
            $table->integer('category_id');
            $table->string('meta_title')->nullable();
            $table->mediumText('meta_keyword')->nullable();
            $table->mediumText('meta_description')->nullable();
            $table->string('slug');
            $table->string('name');
            $table->longText('description');
            $table->string('brand');
            $table->string('selling_price');
            $table->string('original_price');
            $table->string('qty');
            $table->string('image')->nullable();
            $table->tinyInteger('featured')->default('0');
            $table->tinyInteger('papular')->default('0');
            $table->tinyInteger('status')->default('0');

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
