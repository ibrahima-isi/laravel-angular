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
        Schema::table('burgers', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
            $table->string('name')->unique()->change();
            $table->integer('quantity')->after('price')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('burgers', ['image', 'name', 'quantity']);
    }
};
