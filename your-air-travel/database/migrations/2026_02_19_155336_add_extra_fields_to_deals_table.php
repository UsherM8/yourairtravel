<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            // We voegen de missende velden toe, en maken ze 'nullable' (optioneel)
            $table->decimal('discounted_price', 8, 2)->nullable()->after('price');
            $table->string('departure_country')->nullable()->after('departure_city');
            $table->string('arrival_country')->nullable()->after('arrival_city');
            $table->date('return_date')->nullable()->after('departure_date');
            $table->json('tags')->nullable(); // JSON is perfect voor array's zoals tags
        });
    }

    public function down()
    {
        Schema::table('deals', function (Blueprint $table) {
            // Dit is voor als je de migratie ooit wilt terugdraaien
            $table->dropColumn([
                'discounted_price',
                'departure_country',
                'arrival_country',
                'return_date',
                'tags'
            ]);
        });
    }
};
