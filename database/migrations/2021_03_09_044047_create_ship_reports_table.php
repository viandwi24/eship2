<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ship_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('route_id')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->integer('count_adult')->default(0);
            $table->integer('count_baby')->default(0);
            $table->integer('count_security_forces')->default(0);
            $table->integer('count_vehicle_wheel_2')->default(0);
            $table->integer('count_vehicle_wheel_4')->default(0);
            $table->string('photo_embarkation', 255)->nullable();
            $table->string('photo_departure', 255)->nullable();
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
        Schema::dropIfExists('ship_reports');
    }
}
