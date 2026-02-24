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
    Schema::table('deals', function (Blueprint $table) {
        // We voegen de kolom toe, standaard staat hij op 0
        $table->integer('click_count')->default(0)->after('is_active');
    });
}

public function down(): void
{
    Schema::table('deals', function (Blueprint $table) {
        $table->dropColumn('click_count');
    });
}
};
