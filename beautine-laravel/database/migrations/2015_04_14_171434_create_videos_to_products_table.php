<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosToProductsTable extends Migration {
//Mapping Table to track many-to-many relationship of videos to products

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos_to_products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('video_id')->unsigned();
			$table->foreign('video_id')->references('id')->on('videos');

			$table->integer('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products');

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
		Schema::drop('videos_to_products');
	}

}
