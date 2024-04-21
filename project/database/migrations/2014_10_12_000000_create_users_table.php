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
            $table->string('admission_date',10)->comment('Admission Date')->nullable();
			$table->string('name_sei',100)->comment('姓');
			$table->string('name_mei',100)->comment('名');
			$table->string('name_sei_kana',100)->comment('セイ');
			$table->string('name_mei_kana',100)->comment('メイ');
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
			$table->text('profile_photo_path',50)->nullable();
            $table->text('address')->nullable()->comment('住所');
			$table->string('password')->nullable();
            $table->string('reason_coming',200)->nullable();
            $table->string('total_points',6)->nullable(); 
            $table->string('referee_num',18)->nullable();
            $table->string('referee_target_serial',50)->nullable();
            $table->string('zankin',10)->nullable()->comment('支払い残金');
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
