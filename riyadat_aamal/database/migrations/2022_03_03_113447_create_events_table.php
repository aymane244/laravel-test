<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('start');
            $table->string('end')->nullable();
            $table->integer('id_entreprise')->unsigned();
            $table->integer('id_entreprise_rendez_vous')->unsigned()->nullable();
            $table->string('etat_rendez_vous')->nullable();
            $table->foreign('id_entreprise')->references('id')->on('entreprise')->onDelete('cascade');
            $table->foreign('id_entreprise_rendez_vous')->references('id')->on('entreprise')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
