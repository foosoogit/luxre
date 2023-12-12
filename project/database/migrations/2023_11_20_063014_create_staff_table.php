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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('serial_staff',10)->unique();
            $table->string('email',255)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('last_name_kanji',50)->nullable();
            $table->string('first_name_kanji',50)->nullable();
            $table->string('last_name_kana',50)->nullable();
            $table->string('first_name_kana',50)->nullable();
            $table->string('birth_date',12)->nullable();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
