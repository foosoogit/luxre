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
        Schema::create('sales_records', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
			$table->string('serial_sales',30)->unique();
			$table->string('serial_user',20);
			$table->string('serial_good',20)->nullable();
			$table->string('date_sale',20)->nullable()->comment('販売日');
			$table->string('selling_price',20)->nullable()->comment('販売価格');
			$table->string('buying_price',20)->nullable()->comment('仕入れ価格');
			$table->text('memo')->nullable()->comment('メモ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_records');
    }
};
