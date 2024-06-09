<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('kiralamalar', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('kitap_id');
        $table->timestamp('kiralama_tarihi')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->timestamp('iade_tarihi')->nullable();

        $table->foreign('user_id')->references('id')->on('users');
        $table->foreign('kitap_id')->references('id')->on('kitaplar');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kiralamalar');
    }
};
