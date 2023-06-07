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
            $table->foreignId('permission_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('entity_id')->constrained();
        });

        Schema::create('user_has_roles', function (Blueprint $table) {
            $table->primary(['user_id', 'role_id', 'entity_id']);
            $table->foreignId('role_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('entity_id')->constrained();
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->primary(['permission_id', 'role_id']);
            $table->foreignId('permission_id')->constrained();
            $table->foreignId('role_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_has_permissions');
        Schema::drop('model_has_roles');
        Schema::drop('model_has_permissions');
        Schema::drop('roles');
        Schema::drop('permissions');
    }
}
