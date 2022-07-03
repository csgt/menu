<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMenuUseNames extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('menus', 'module_permission_id')) {
            DB::unprepared("TRUNCATE TABLE menus");
            Schema::table('menus', function (Blueprint $table) {
                $table->string('parent_route')->after('order')->nullable()->default(null);
                $table->dropForeign(['module_permission_id']);
                $table->dropForeign(['parent_id']);
                $table->dropColumn('module_permission_id');
                $table->dropColumn('parent_id');
                $table->boolean('has_children')->default(false)->after('icon');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('menus', 'module_permission')) {
            Schema::table('menus', function (Blueprint $table) {
                $table->unsignedInteger('parent_id');
                $table->dropColumn('has_children');
                $table->dropColumn('module_permission');
                $table->foreign('module_permission_id')->references('id')->on('module_permissions');
            });
        }
    }
}
