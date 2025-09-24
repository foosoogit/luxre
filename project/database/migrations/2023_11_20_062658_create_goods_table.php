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
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('branch',20)->comment('支店番号');
			$table->string('serial_good',10)->nullable();
			$table->string('model_nmber',30)->nullable()->comment('型番');
			$table->string('buying_price',20)->nullable()->comment('買値');
			$table->string('zaiko',20)->nullable()->comment('在庫数');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods');
    }
};
