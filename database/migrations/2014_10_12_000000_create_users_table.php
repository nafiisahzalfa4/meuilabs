<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password');

            $table->enum('role', [
                'admin',
                'customer',
                'designer'
            ])->default('customer');

            $table->string('no_telepon', 20)->nullable(); 
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}