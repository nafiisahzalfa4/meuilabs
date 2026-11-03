<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('designer_id')->nullable();
            $table->unsignedBigInteger('service_id');

            $table->date('tanggal_pesan');
            $table->text('catatan')->nullable();
            $table->decimal('total_harga', 12, 2);

            $table->enum('status', [
                'menunggu',
                'diproses',
                'selesai',
                'dibatalkan'
            ])->default('menunggu');

            $table->timestamps();

            $table->foreign('customer_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('designer_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->foreign('service_id')
                  ->references('id')->on('services')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}