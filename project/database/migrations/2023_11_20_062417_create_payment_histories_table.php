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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('branch',20)->comment('支店番号');
            $table->string('payment_history_serial',20)->unique()->comment('テーブルシリアル');
            $table->string('serial_keiyaku',20)->comment('契約番号');
            $table->string('serial_user',20)->comment('顧客番号');
            $table->string('serial_staff',20)->nullable()->comment('ID Staff');
            $table->string('date_payment',20)->nullable()->comment('支払日');
            $table->string('amount_payment',20)->nullable()->comment('支払金額');
            $table->string('how_to_pay',20)->nullable()->comment('支払方法');
            $table->text('remarks')->nullable()->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
