<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommandationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommandation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamp('date_recom')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('id_entreprise')->unsigned();
            $table->integer('id_entreprise_recom')->unsigned();
            $table->integer('rating')->nullable();
            $table->text('comment')->nullable();
            $table->string('etat_recom')->default('en attente');
            $table->foreign('id_entreprise')->references('id')->on('entreprise')->onDelete('cascade');
            $table->foreign('id_entreprise_recom')->references('id')->on('entreprise')->onDelete('cascade');
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
        Schema::dropIfExists('recommandation');
    }
}
