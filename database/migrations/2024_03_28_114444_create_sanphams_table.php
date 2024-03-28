<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sanphams', function (Blueprint $table) {
            $table->id();
            $table->integer('idmenu');
            $table->integer('idcolor');
            $table->integer('idGB');
            $table->string('tensp');
            $table->text('mota');
            $table->string('img');
            $table->string('img1');
            $table->string('img2');
            $table->string('img3');
            $table->bigInteger('dongia');
            $table->bigInteger('giamgia');
            $table->integer('slton');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanphams');
    }
};
