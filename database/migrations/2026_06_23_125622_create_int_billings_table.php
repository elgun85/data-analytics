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
        Schema::create('int_billings', function (Blueprint $table) {
            $table->id();
            $table->string('telefon')->nullable()->index();
            $table->string('ad')->nullable();
            $table->decimal('abune', 8, 2)->nullable();
            $table->decimal('balans', 8, 2)->nullable();
            $table->integer('nov')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('int_billings');
    }
};
