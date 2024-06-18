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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_savings_id_foreign');
            $table->dropColumn('savings_id');
            $table->dropColumn('discount');
            $table->dropColumn('for');
            $table->renameColumn('price', 'amount');
            $table->string('description')->nullable()->after('price');
            $table->string('proof')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
