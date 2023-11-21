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
        Schema::create('visit_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('visit_history_serial',20)->unique()->comment('テーブルシリアル');
            $table->string('serial_keiyaku',20)->comment('契約番号');
            $table->string('serial_user',20)->comment('serial_user');
            $table->string('serial_Teacher',20)->nullable()->comment('ID Teacher');
            $table->string('date_visit',20)->nullable()->comment('来店日');
            $table->text('remarks')->nullable()->comment('備考');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_histories');
    }
};
