<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('user_has_permissions', function (Blueprint $table) {
            $table->primary(['user_id', 'permission_id', 'entity_id']);
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('entity_id');
        });

        Schema::create('user_has_roles', function (Blueprint $table) {
            $table->primary(['user_id', 'role_id', 'entity_id']);
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('entity_id');
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->primary(['permission_id', 'role_id']);
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions');
        Schema::drop('roles');
        Schema::drop('user_has_permissions');
        Schema::drop('user_has_roles');
        Schema::drop('role_has_permissions');
    }
}
