<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remedials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->string('circuitNo');
            $table->string('room');
            $table->longText('description');
            $table->boolean('approved');
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
        Schema::dropIfExists('remidials');
    }
};
