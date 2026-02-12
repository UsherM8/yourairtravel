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
    Schema::create('deal_images', function (Blueprint $table) {
        $table->id();
        // De koppeling naar de deal
        $table->foreignId('deal_id')->constrained()->onDelete('cascade');
        $table->string('path'); // Het pad naar de foto
        $table->boolean('is_primary')->default(false); // Om te weten welke op de voorpagina moet
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_images');
    }
};
