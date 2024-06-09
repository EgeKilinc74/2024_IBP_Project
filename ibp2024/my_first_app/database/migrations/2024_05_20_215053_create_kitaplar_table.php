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
        Schema::create('kitaplar', function (Blueprint $table) {
            $table->id(); // Kitap ID (primary key)
            $table->string('kitap_adi'); // Kitap adı
            $table->string('yazar'); // Yazar adı
            $table->integer('mevcutluk')->default(0); // Mevcutluk (default 0)
            $table->timestamps(); // created_at ve updated_at timestamp'leri
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kitaplar');
    }
};
