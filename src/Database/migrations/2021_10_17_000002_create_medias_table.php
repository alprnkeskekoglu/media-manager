<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('folder_id')->nullable();
            $table->string('uid')->nullable();
            $table->boolean('private')->default(0);
            $table->tinyInteger('type')->default(1);
            $table->string('name');
            $table->string('extension');
            $table->string('full_name');
            $table->string('mime_class');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('folder_id')->references('id')->on('folders')->cascadeOnDelete();
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
