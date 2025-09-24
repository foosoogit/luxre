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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('branch',20)->comment('支店番号');
            $table->string('name',50);
			$table->string('serial_admin',10)->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            //$table->string('email_verify_token')->nullable();
            $table->string('password');
            $table->rememberToken();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
