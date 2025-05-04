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
        Schema::create('tbl_form', function (Blueprint $table) {
            $table->increments('form_id');
            $table->string('form_name', 255);
            $table->timestamp('form_created');
            $table->timestamp('form_updated');
            $table->timestamp('department_equipment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_form');
    }
};
