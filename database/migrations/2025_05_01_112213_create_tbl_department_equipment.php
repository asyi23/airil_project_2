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
        Schema::create('tbl_department_equipment', function (Blueprint $table) {
            $table->increments('deparment_equipment_id', 255);
            $table->string('deparment_equipment_name');
            $table->integer('department_id');
            $table->timestamp('deparment_equipment_created');
            $table->timestamp('deparment_equipment_updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_department_equipment');
    }
};
