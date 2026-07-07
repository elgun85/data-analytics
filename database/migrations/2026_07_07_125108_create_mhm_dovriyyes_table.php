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
        Schema::create('mhm_dovriyyes', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('service_code')->nullable();
            $table->integer('phone')->nullable();
            $table->integer('order_number')->nullable();
            $table->string('name')->nullable();
            $table->string('vat_status',5)->nullable();
            $table->string('organization_type')->nullable();
            $table->unsignedTinyInteger('category')->nullable();
            $table->bigInteger('opening_balance')->nullable();
            $table->bigInteger('payment_amount')->nullable();
            $table->bigInteger('accrual_amount')->nullable();
            $table->bigInteger('storno_amount')->nullable();
            $table->bigInteger('closing_balance')->nullable();


         //   $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mhm_dovriyyes');
    }
};
