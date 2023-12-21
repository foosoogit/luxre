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
        DB::unprepared('
        CREATE TRIGGER `残金計算-keiyakus delete`
        AFTER DELETE
        ON contracts FOR EACH ROW
        BEGIN
        CALL zankin(old.serial_user);
        END
        ');

        DB::unprepared('
        CREATE TRIGGER `残金計算-keiyakus insert`
            AFTER INSERT
            ON contracts FOR EACH ROW
            BEGIN
            CALL zankin(NEW.serial_user);
            END
        ');

        DB::unprepared('
            CREATE TRIGGER `残金計算-keiyakus update`
            AFTER UPDATE
            ON contracts FOR EACH ROW
            BEGIN
            CALL zankin(NEW.serial_user);
            END
        ');

        DB::unprepared('
            CREATE TRIGGER `残金計算-payment_histories delete`
            BEFORE DELETE
            ON payment_histories FOR EACH ROW
            BEGIN
            CALL zankin(OLD.serial_user);
            END
        ');

        DB::unprepared('
            CREATE TRIGGER `残金計算-payment_histories insert`
            AFTER INSERT
            ON payment_histories FOR EACH ROW
            BEGIN
            CALL zankin(NEW.serial_user);
            END
        ');

        DB::unprepared('
            CREATE TRIGGER `残金計算-payment_histories update`
            AFTER UPDATE
            ON payment_histories FOR EACH ROW
            BEGIN
            CALL zankin(NEW.serial_user);
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER `残金計算-keiyakus delete`');
        DB::unprepared('DROP TRIGGER `残金計算-keiyakus insert`');
        DB::unprepared('DROP TRIGGER `残金計算-keiyakus update`');
        DB::unprepared('DROP TRIGGER `残金計算-payment_histories delete`');
        DB::unprepared('DROP TRIGGER `残金計算-payment_histories insert`');
        DB::unprepared('DROP TRIGGER `残金計算-payment_histories update`');
    }
};
