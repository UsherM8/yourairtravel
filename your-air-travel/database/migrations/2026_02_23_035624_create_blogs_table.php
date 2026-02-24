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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content')->nullable(); // longText omdat een blog lekker lang kan zijn!

            // Bestemmingen (Handig als je later blogs aan deals wilt koppelen!)
            $table->string('arrival_country')->nullable();
            $table->string('arrival_city')->nullable();

            $table->string('image_path')->nullable(); // De grote hoofdfoto van de blog
            $table->json('tags')->nullable();
            $table->boolean('is_active')->default(true); // Net als bij deals: het draft/live schuifje

            // De auteur die de blog heeft geschreven
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
