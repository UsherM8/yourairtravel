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
        $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('departure_city');
        $table->string('arrival_city');
        $table->string('arrival_country');
        $table->decimal('price', 8, 2);
        $table->decimal('discounted_price', 8, 2)->nullable();
        $table->string('airline')->nullable();
        $table->date('departure_date')->nullable();

        // DEZE REGEL IS CRUCIAAL EN ONTBRRAK WAARSCHIJNLIJK:
        $table->date('return_date')->nullable();

        // Nu we hier toch zijn, zetten we deze er ook direct in,
        // dan heb je dat aparte tweede migratiebestand (add_duration_days...) niet meer nodig!
        $table->string('duration_days')->nullable();

        $table->json('tags')->nullable();
        $table->boolean('is_active')->default(true);
        $table->string('referral_url')->nullable();
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
