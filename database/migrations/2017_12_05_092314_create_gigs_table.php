<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gigs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('category');
            $table->string('image')->nullable();
            $table->text('addon_services')->nullable();
            $table->integer('regular_price')->default(0);
            $table->integer('sale_price');
            $table->tinyInteger('count')->default(0);
            $table->date('expires_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_public')->default(false);
            $table->integer('delivery_time')->nullable();
            $table->boolean('is_local')->default(false);
            $table->string('uid');
            $table->string('slug');
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
        Schema::dropIfExists('gigs');
    }
}
