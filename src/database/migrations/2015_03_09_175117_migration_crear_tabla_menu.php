<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationCrearTablaMenu extends Migration {

	public function up() {
		Schema::create('menu', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('parent_id')->nullable()->unsigned();
			$table->integer('module_permission_id')->nullable()->unsigned();
			$table->string('name');
			$table->integer('order');
			$table->string('route')->nullable();
			$table->string('icon')->nullable();
			$table->timestamps();

			$table->foreign('module_permission_id')->references('id')->on('module_permissions')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('parent_id')->references('id')->on('menu')->onDelete('restrict')->onUpdate('cascade');

		});
	}

	public function down() {
		Schema::drop('menu');
	}

}
