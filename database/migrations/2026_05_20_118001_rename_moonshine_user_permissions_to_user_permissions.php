<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('moonshine_user_permissions') && ! Schema::hasTable('user_permissions')) {
            Schema::rename('moonshine_user_permissions', 'user_permissions');
        }

        if (! Schema::hasColumn('user_permissions', 'moonshine_user_id')) {
            return;
        }

        Schema::table('user_permissions', function (Blueprint $table): void {
            $table->dropForeign(['moonshine_user_id']);
        });

        Schema::table('user_permissions', function (Blueprint $table): void {
            $table->renameColumn('moonshine_user_id', 'user_id');
        });

        Schema::table('user_permissions', function (Blueprint $table): void {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('user_permissions', 'user_id')) {
            return;
        }

        Schema::table('user_permissions', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
        });

        Schema::table('user_permissions', function (Blueprint $table): void {
            $table->renameColumn('user_id', 'moonshine_user_id');
        });

        Schema::table('user_permissions', function (Blueprint $table): void {
            $table->foreign('moonshine_user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });

        if (Schema::hasTable('user_permissions') && ! Schema::hasTable('moonshine_user_permissions')) {
            Schema::rename('user_permissions', 'moonshine_user_permissions');
        }
    }
};
