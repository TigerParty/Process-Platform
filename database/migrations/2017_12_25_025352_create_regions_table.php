<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label_name', 32)->nullable();
            $table->integer('parent_id')->nullable()->unsigned();
            $table->integer('order')->default(1);

            $table->string('capital')->nullable();
            $table->double('capital_lat')->nullable();
            $table->double('capital_lng')->nullable();
            $table->text('map_path')->nullable();
            $table->string('map_title_x')->nullable();
            $table->string('map_title_y')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('label_name')->references('name')->on('region_label');
            $table->foreign('parent_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
