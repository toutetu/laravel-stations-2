<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('上映日');
            $table->unsignedBigInteger('schedule_id')->comment('スケジュールID');
            $table->unsignedBigInteger('sheet_id')->comment('シートID');
            $table->string('email')->comment('予約者メールアドレス');
            $table->string('name')->comment('予約者名');
            $table->boolean('is_canceled')->default(false)->comment('予約キャンセル済み');
            $table->timestamps();
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('sheet_id')->references('id')->on('sheets')->onDelete('cascade');
            $table->unique(['schedule_id', 'sheet_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
