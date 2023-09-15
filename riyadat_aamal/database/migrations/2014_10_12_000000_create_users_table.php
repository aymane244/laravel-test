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
        Schema::create('entreprise', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('tele')->nullable();
            $table->string('adress')->nullable();
            $table->text('logo')->nullable();
            $table->string('email')->unique();
            $table->boolean('etat_compte')->default(false);
            $table->string('type_entreprise')->nullable();
            $table->integer('rating')->nullable();
            $table->string('num_rc')->nullable();
            $table->string('ide_fiscal')->nullable();
            $table->string('num_ice')->nullable();
            $table->string('num_cnss')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->boolean('isAdmin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('entreprise');
    }
}
