<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MakeGambarNullableOnServicesTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE services MODIFY gambar VARCHAR(255) NULL DEFAULT NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE services MODIFY gambar VARCHAR(255) NOT NULL');
    }
}