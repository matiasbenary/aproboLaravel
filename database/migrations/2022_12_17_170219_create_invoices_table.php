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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('contract_id')->nullable()->constrained();
            $table->foreignId('media_id')->nullable()->constrained()->nullable();
            $table->foreignId('project_id')->constrained();
            $table->enum('type', ['B', 'C', 'Nota de crédito']);
            $table->enum('currency', ['ARS', 'USD', 'MX', 'COP', 'Otro']);
            $table->unsignedBigInteger('amount');
            $table->string('state');
            $table->unsignedSmallInteger('signatures')->default(0);
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
        Schema::dropIfExists('invoices');
    }
};
