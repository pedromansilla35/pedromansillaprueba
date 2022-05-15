<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelationtagMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_tag', function (Blueprint $table) {
           // $table->engine = 'InnoDB';
            $table->increments("id");
            $table->unsignedBigInteger('id_tag')->nullable();
            $table->unsignedBigInteger('id_video')->nullable();
            $table->unsignedBigInteger('id_post')->nullable();
            $table->timestamps();
            //$table->foreign('id_tag')->references('id')->on('tag')->onDelete('cascade');
            //$table->foreign('id_video')->references('id')->on('video')->onDelete('cascade');
            //$table->foreign('id_post')->references('id')->on('post')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
