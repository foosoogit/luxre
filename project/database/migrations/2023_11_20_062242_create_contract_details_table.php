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
        Schema::create('contract_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('contract_detail_serial',10)->unique()->comment('契約詳細シリアル');
            $table->string('serial_keiyaku',10)->comment('契約番号');
            $table->string('serial_user',10)->comment('serial_user');
            $table->string('serial_staff',10)->nullable()->comment('ID Staff');
            $table->string('keiyaku_naiyo')->nullable()->comment('契約内容');
            $table->string('keiyaku_num',10)->nullable()->comment('回数');
            $table->string('unit_price',10)->nullable()->comment('単価');
            $table->string('price',10)->nullable()->comment('料金');
            $table->text('remarks')->nullable()->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_details');
    }
};
