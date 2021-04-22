<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->tinyInteger('type')->default(1);
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('brand_id')->constrained();
            $table->tinyInteger('status')->default(1);
            $table->string('image')->nullable();
            $table->boolean('is_in_home')->default(false);
            $table->tinyInteger('warranty')->nullable();
            $table->json('options')->nullable();
            
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
