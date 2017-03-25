<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('location')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->boolean('account_type')->default(false);
            $table->date('dob')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('location');
            $table->dropColumn('gender');
            $table->dropColumn('account_type');
            $table->dropColumn('dob');
        });
    }
}
