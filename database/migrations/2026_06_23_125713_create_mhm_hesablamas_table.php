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
        Schema::create('mhm_hesablamas', function (Blueprint $table) {
            $table->id();
            $table->integer('hesab')->nullable()->index();
            $table->string('telefon')->nullable()->index();
            $table->decimal('summa', 8, 2)->nullable();
            $table->integer('abonent')->nullable();
            $table->integer('kod')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mhm_hesablamas');
    }
};
