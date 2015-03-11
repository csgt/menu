<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationCrearTablaMenu extends Migration {

	public function up() {
		Schema::create('authmenu', function(Blueprint $table) {
			$table->increments('menuid');
			$table->integer('padreid')->nullable()->unsigned();
			$table->integer('modulpermisoid')->nullable()->unsigned();
			$table->string('nombre',50);
			$table->integer('orden');
			$table->string('icono',50)->nullable();
			$table->timestamps();

			$table->foreign('modulopermisoid')->references('modulopermisoid')->on('authmodulopermisos')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('padreid')->references('menuid')->on('authmenu')->onDelete('restrict')->onUpdate('cascade');

		});
	}

	public function down() {
		Schema::drop('authmenu');
	}

}
