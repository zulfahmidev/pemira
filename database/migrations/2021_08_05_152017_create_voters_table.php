<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim');
            $table->string('email');
            $table->string('jurusan');
            $table->string('password')->nullable();
            $table->string('login_token')->nullable();
            $table->bigInteger('cdpm_id')->unsigned()->nullable();
            $table->bigInteger('cbem_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('cdpm_id')->references('id')->on('dpm_cadidates')->restrictOnDelete();
            $table->foreign('cbem_id')->references('id')->on('bem_cadidates')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voters');
    }
}
