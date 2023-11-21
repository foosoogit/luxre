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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('serial_user')->unique();
			$table->string('name_sei',30);
			$table->string('name_mei',30);
			$table->string('name_sei_kana',30);
			$table->string('name_mei_kana',30);
			$table->string('gender',10)->nullable();
			$table->string('birth_year',10)->nullable();
			$table->string('birth_month',10)->nullable();
			$table->string('birth_day',10)->nullable();
			$table->string('postal',15)->nullable();
			$table->string('address_region')->nullable();
			$table->string('address_locality')->nullable();
			$table->string('address_banti')->nullable();
			$table->string('email')->nullable();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('phone',20)->nullable();
			$table->string('password')->nullable();
			$table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
