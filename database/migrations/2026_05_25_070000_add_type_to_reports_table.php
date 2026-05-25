<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('reports') || Schema::hasColumn('reports', 'type')) {
            return;
        }

        Schema::table('reports', function (Blueprint $table) {
            $table->unsignedTinyInteger('type')->after('to');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('reports', 'type')) {
            return;
        }

        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
