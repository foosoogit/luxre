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
        Schema::create('account_subjects', function (Blueprint $table) {
            $table->id()->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->string('subject',20)->comment('科目');
            $table->string('category',20)->comment('カテゴリー');
            $table->text('remarks')->nullable()->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_subjects');
    }
};
