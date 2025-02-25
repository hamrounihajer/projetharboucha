<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('order_id');
          $table->string('payment_token');
          $table->decimal('amount', 10, 2);
          $table->string('status'); // par exemple: success, failed
          $table->timestamps();

          $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
      });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
