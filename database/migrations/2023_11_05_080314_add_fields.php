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
        Schema::table('rented_rooms', function (Blueprint $table) {
            $table->text('id_image')->nullable();
            $table->dateTime('rented_date')->nullable();
            $table->double('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rented_rooms', function (Blueprint $table) {
            $table->dropColumn('id_image');
            $table->dropColumn('id_number');
            $table->dropColumn('price');
        });
    }
};
