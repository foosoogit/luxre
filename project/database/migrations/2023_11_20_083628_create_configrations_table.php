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
        Schema::create('configrations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('branch',20)->comment('支店番号');
            $table->string('subject', 50)->comment('key');
            $table->text('value1')->comment('value-1');
            $table->text('value2')->nullable()->comment('value-2');
            $table->text('setumei')->comment('説明');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configrations');
    }
};
