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
        Schema::create('gh8_lks', function (Blueprint $table) {
            $table->id();
            $table->string('NOTEL')->nullable()->index();
            $table->integer('KODQURUM')->nullable()->index();
            $table->integer('ABONENT')->nullable();
            $table->integer('KODTARIF')->nullable();
            $table->decimal('SUMMA', 8, 2)->nullable();
            $table->integer('SAYTEL')->nullable();
            $table->integer('KODISH')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gh8_lks');
    }
};
