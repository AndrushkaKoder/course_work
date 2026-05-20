<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('moonshine_user_roles') && ! Schema::hasTable('user_roles')) {
            Schema::rename('moonshine_user_roles', 'user_roles');
        }

        if (! Schema::hasColumn('users', 'moonshine_user_role_id')) {
            return;
        }

        Schema::table('users', function (Blueprint $table): void {
            $table->dropForeign(['moonshine_user_role_id']);
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->renameColumn('moonshine_user_role_id', 'user_role_id');
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->foreign('user_role_id')
                ->references('id')
                ->on('user_roles')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('users', 'user_role_id')) {
            return;
        }

        Schema::table('users', function (Blueprint $table): void {
            $table->dropForeign(['user_role_id']);
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->renameColumn('user_role_id', 'moonshine_user_role_id');
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->foreign('moonshine_user_role_id')
                ->references('id')
                ->on('user_roles')
                ->nullOnDelete();
        });

        if (Schema::hasTable('user_roles') && ! Schema::hasTable('moonshine_user_roles')) {
            Schema::rename('user_roles', 'moonshine_user_roles');
        }
    }
};
