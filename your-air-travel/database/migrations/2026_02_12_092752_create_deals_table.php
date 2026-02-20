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
    Schema::create('deals', function (Blueprint $table) {
        // 1. Marketing Info (De "Deal" kant)
        $table->id();
        $table->string('title');          // Bijv: "Weekendje Barcelona"
        $table->text('description');      // Korte wervende tekst
        $table->string('referral_url');   // De link naar Skyscanner/Transavia
        $table->integer('click_count')->default(0);

        // 2. Vlucht Info (De "Snapshot" kant)
        // We slaan hier alleen op wat nodig is voor de "Card" op de site
        $table->string('airline')->nullable();        // Bijv: "KLM"
        $table->string('departure_country')->nullable();
        $table->string('departure_city');             // Bijv: "Amsterdam"
        $table->string('arrival_country')->nullable();
        $table->string('arrival_city');               // Bijv: "Barcelona"
        $table->decimal('price', 8, 2);               // De prijs op moment van vinden
        $table->decimal('discounted_price',8,2);
        $table->dateTime('departure_date')->nullable(); // Handig voor sorteren'

        // 3. Status
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */ 
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
