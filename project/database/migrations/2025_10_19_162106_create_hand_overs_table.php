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
        Schema::create('hand_overs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('branch',20)->comment('支店番号');
            $table->string('target_date',10)->comment('日付');
            $table->string('serial_staff',10)->comment('入力スタッフシリアル');
            $table->text('handover',10)->nullable()->comment('申し送り');
            $table->text('daily_report',100)->nullable()->comment('日報');
            $table->string('inputter',10)->nullable()->comment('ログイン者');
            $table->text('remarks')->nullable()->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hand_overs');
    }
};
