<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlogsTableAddCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('uid');
            $table->boolean('allow_comments')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('excerpt');
            $table->dropColumn('uid');
            $table->dropColumn('allow_comments');
        });
    }
}
