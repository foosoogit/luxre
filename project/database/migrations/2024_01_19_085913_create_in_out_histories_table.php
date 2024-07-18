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
        Schema::create('in_out_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('target_serial')->comment('対象者シリアル');
            $table->string('target_date',10)->comment('日付');
            $table->string('time_in',20)->comment('入出時間');
            $table->string('time_out',20)->nullable()->comment('退出時間');
            $table->string('target_name',50)->nullable()->comment('氏名');
            $table->string('staff_name_kana',50)->nullable()->comment('しめい');
            $table->string('to_mail_address',200)->nullable()->comment('送り先メールアドレス');
            $table->string('from_mail_address',50)->nullable()->comment('送り元メールアドレス');
            $table->text('reason_late')->nullable()->comment('遅刻理由');
            $table->text('remarks')->nullable()->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('in_out_histories');
    }
};
