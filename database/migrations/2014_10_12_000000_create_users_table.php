<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 128)->unique();
            $table->string('password', 128);
            $table->string('username', 64)->unique()->nullable();
            $table->string('first_name', 128)->unique();
            $table->string('last_name', 128)->unique();
            $table->string('phone_number', 128)->unique();
            $table->string('bio')->unique()->nullable();
            $table->string('location')->unique()->nullable();
            $table->string('website')->unique()->nullable();
            $table->date('date_of_birth')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable()->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
