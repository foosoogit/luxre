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
        Schema::create('cash_books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('target_date',10)->comment('日付');
            $table->string('in_out',10)->comment('入金/出金');
            $table->string('summary',100)->nullable()->comment('摘要');
            $table->string('payment',10)->comment('支払い金額');
            $table->string('deposit',10)->nullable()->comment('入金額');
            $table->string('inputter',10)->nullable()->comment('入力者');
            $table->text('remarks')->nullable()->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_books');
    }
};
