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
        Schema::create('treatment_contents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('branch',20)->comment('支店番号');
			$table->string('serial_treatment_contents',20)->comment('施術シリアル');
			$table->string('name_treatment_contents',255)->comment('施術名');
            $table->string('name_treatment_contents_kana',255)->nullable()->comment('施術名カナ');
			$table->text('treatment_details')->textable()->nullable()->comment('施術説明');
			$table->text('memo')->nullable()->comment('メモ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_contents');
    }
};
