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
            $table->string('nationalId')->unique()->nullable();
            $table->string('name');
            $table->string('password')->nullable();
            $table->string('email')->unique();
            $table->date('date_of_birth')->nullable();;
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('avatar')->nullable();;
            $table->timestamp('email_verified_at')->nullable();
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
