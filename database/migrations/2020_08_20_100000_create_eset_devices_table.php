<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsetDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eset_devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('device_id')->index();
            $table->unsignedBigInteger('credit_id')->index();
            $table->json('data')->nullable();  
            $table->timestamps();    
            $table->softDeletes();

            $table
                ->foreign('credit_id')
                ->references('id')->on('el_credits')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eset_devices');
    }
}
