<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lahans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('tinggi_tempat');
            $table->decimal('suhu');
            $table->decimal('curah_hujan');
            $table->integer('jumlah_bulan_kering');
            $table->decimal('ph');
            $table->decimal('bo');
            $table->decimal('kedalaman');
            $table->decimal('kemiringan');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        //
    }
}
