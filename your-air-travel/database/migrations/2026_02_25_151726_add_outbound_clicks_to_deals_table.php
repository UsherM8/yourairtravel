<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            // We noemen deze 'outbound_clicks' om verwarring te voorkomen
            $table->unsignedInteger('outbound_clicks')->default(0)->after('clicks');
        });
    }

    public function down(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropColumn('outbound_clicks');
        });
    }
};
