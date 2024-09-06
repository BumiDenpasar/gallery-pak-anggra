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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('img');
            $table->string('title');
            $table->longText('desc');
            $table->timestamps();
        });

        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('desc');
            $table->timestamps();
        });

        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery');
        Schema::dropIfExists('info');
        Schema::dropIfExists('agenda');
    }
};
