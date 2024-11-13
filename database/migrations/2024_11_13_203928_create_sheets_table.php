<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSheetsTable extends Migration
{
    public function up()
    {
        Schema::create('sheets', function (Blueprint $table) {
            $table->id();
            $table->integer('column');
            $table->string('row');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sheets');
    }
}