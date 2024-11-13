<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->comment('映画タイトル');
            $table->text('image_url')->comment('画像URL');
            $table->integer('published_year')->nullable()->comment('公開年');
            $table->boolean('is_showing')->default(false)->comment('公開中かどうか');
            $table->text('description')->nullable()->comment('概要');
            $table->unsignedBigInteger('genre_id')->nullable();
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movies');
    }
};