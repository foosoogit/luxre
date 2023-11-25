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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('serial_branch',10)->unique()->comment('シリアル ');
            $table->string('name_branch',100)->comment('支店名');
            $table->string('postal',15)->nullable()->comment('郵便番号');
            $table->string('address_branch',200)->nullable()->comment('支店住所');
            $table->string('phone_branch',100)->nullable()->comment('電話番号');
            $table->string('email')->nullable()->comment('支店メールアドレス');
            $table->string('open_date',12)->nullable()->comment('開院日');
            $table->text('note')->nullable()->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
