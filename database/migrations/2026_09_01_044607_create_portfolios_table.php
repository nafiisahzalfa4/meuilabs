<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfoliosTable extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();

            // Designer yang membuat portfolio
            $table->foreignId('designer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Data portfolio
            $table->string('judul', 100);
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();

            // Kategori portfolio
            $table->enum('kategori', [
                'website',
                'mobile',
                'dashboard',
                'lainnya'
            ])->default('website');

            $table->timestamps();
        });
    }

    /**
     * Batalkan migration.
     */
    public function down()
    {
        Schema::dropIfExists('portfolios');
    }
}