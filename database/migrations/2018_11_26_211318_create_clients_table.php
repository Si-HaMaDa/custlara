<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('age');
            $table->string('country')->nullable();
            $table->string('fb')->nullable();
            $table->integer('phone')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('preflang')->default('EN');
            $table->string('addby')->unsigned();
            $table->foreign('addby')->references('id')->on('users');
            $table->integer('f_calls')->default(0);
            $table->json('f_calls_rec')->nullable();
            $table->string('respon_id')->unsigned()->nullable();
            $table->foreign('respon_id')->references('id')->on('users');
            $table->integer('statu')->default('n');
            $table->timestamp('init');
            $table->json('tries')->nullable();
            $table->longText('notes')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('clients');
    }
}
