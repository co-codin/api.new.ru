<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('key')->unique();
            $table->json('options')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_hidden_from_product')->default(false);
            $table->boolean('is_hidden_from_comparison')->default(false);
            $table->boolean('is_numeric')->default(false);
            $table->unsignedBigInteger('assigned_by_id')->nullable();
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
        Schema::dropIfExists('properties');
    }
}
