<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_medias', function (Blueprint $table) {
            $table->morphs('model');
            $table->unsignedBigInteger('media_id')->index();
            $table->string('key')->index();
            $table->unsignedInteger('order')->nullable();

            $table->foreign('media_id')->references('id')->on('medias')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medias');
    }
}
