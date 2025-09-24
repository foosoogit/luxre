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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
			
			$table->string('branch',20)->comment('支店番号');
			$table->string('serial_keiyaku', 50)->unique()->comment('契約シリアル-自動');
			$table->string('serial_user',20)->nullable()->comment('serial_user');
			$table->string('serial_staff',20)->nullable()->comment('ID Staff');
			
			$table->string('course')->nullable()->comment('コース');
			$table->string('treatments_num')->nullable()->comment('施術シリアル');
			$table->string('keiyaku_kikan_start',20)->nullable()->comment('契約開始日');
			
			$table->string('keiyaku_kikan_end',20)->nullable()->comment('契約終了日');
			$table->string('keiyaku_type',20)->comment('契約形態(サブスク/期間・内容設定)');
			$table->string('keiyaku_name')->nullable()->comment('契約名');

			$table->string('keiyaku_bi',20)->comment('契約日');
			$table->string('keiyaku_kingaku',20)->comment('契約金額');
			$table->string('keiyaku_num',20)->nullable()->comment('契約回数');

			$table->string('keiyaku_kingaku_total',20)->nullable()->comment('契約金額合計');
			$table->string('how_to_pay')->nullable()->comment('支払い方法');
			$table->string('how_many_pay_genkin',10)->nullable()->comment('支払い回数-現金');

			$table->string('date_first_pay_genkin',20)->nullable()->comment('1回目支払日-現金');
			$table->string('date_second_pay_genkin',10)->nullable()->comment('2回目支払日-現金');
			$table->string('amount_first_pay_cash',20)->nullable()->comment('1回目支払金額');

			$table->string('amount_second_pay_cash',20)->nullable()->comment('2回目支払金額');
			$table->string('card_company',20)->nullable()->comment('クレジットカード会社');
			$table->string('how_many_pay_card',10)->nullable()->comment('支払い回数-クレジットカード');

			$table->string('date_pay_card',20)->nullable()->comment('支払い日-クレジットカード');
			$table->string('tantosya',50)->nullable()->comment('担当者');
			$table->string('serial_tantosya',10)->nullable()->comment('担当者シリアル');
			$table->string('date_latest_visit',20)->nullable()->comment('最終来店日');

			$table->string('cancel',20)->nullable()->comment('キャンセル日');
			$table->text('remarks')->nullable()->comment('備考');
        });
	}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
