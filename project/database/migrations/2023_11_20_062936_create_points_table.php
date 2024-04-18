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
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('serial_user',10)->comment('ユーザーシリアル');
            $table->string('method',10)->comment('取得方法');
            $table->string('date_get',10)->comment('取得日');
            $table->string('point',6)->comment('取得ポイント');
            $table->string('visit_date',10)->nullable()->comment('来店日');
            $table->string('referred_serial',10)->nullable()->comment('紹介された人');
            $table->string('validity_flg',10)->comment('有効フラグ');
            $table->string('digestion_flg',10)->comment('消化フラグ');
            $table->text('note')->nullable()->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
