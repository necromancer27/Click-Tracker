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
            $table->Integer('c_id');
            $table->string('f_name');
            $table->string('l_name');
            $table->string('e_mail');
            $table->string('pass');
            $table->string('token');
            $table->dateTime('valid_till');
            $table->timestamps('Expire on');
            $table->primary('c_id');
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
