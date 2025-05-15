<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('todos', 'category_id')) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        }
        
    }
};
