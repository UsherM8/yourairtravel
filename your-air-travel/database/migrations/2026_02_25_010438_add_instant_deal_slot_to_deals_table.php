<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            // Een getal van 1 t/m 8 (of null als hij niet op de homepage staat)
            $table->tinyInteger('instant_deal_slot')->nullable()->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropColumn('instant_deal_slot');
        });
    }
};
