<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::create("images",function($table) {
		$table->increments("id");
		$table->string("row_type")->nullable();
		$table->string("name")->nullable();
		$table->string("path")->nullable();
		$table->integer("parent_id")->nullable();
		$table->integer("display_order")->nullable();
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
	Schema::drop("images");
    }
}
