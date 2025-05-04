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
        Schema::create('tbl_form_detail', function (Blueprint $table) {
            $table->integer('form_id');
            $table->increments('form_detail_id', 255);
            $table->dateTime('form_detail_date');
            $table->dateTime('form_detail_end_date');
            $table->string('form_detail_order_no');
            $table->integer('form_detail_quantity');
            $table->string('form_detail_oum');
            $table->string('form_detail_done_by');
            $table->string('form_detail_remark');
            $table->timestamp('form_detail_created');
            $table->timestamp('form_detail_updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_form_detail');
    }
};
