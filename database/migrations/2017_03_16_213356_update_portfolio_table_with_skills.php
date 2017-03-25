<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePortfolioTableWithSkills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('skills')->nullable();
            $table->string('url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->date('completion_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn('skills');
            $table->dropColumn('completion_date');
            $table->dropColumn('thumbnail');
            $table->dropColumn('url');
        });
    }
}
