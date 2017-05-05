<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_invites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invitee_name')->nullable();
            $table->string('invitee_email')->nullable();
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->string('medium')->nullable();
            $table->boolean('sent')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('contact_invites');
    }
}
