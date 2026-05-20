<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasColumn('users', 'user_role_id')
            || Schema::hasColumn('users', 'moonshine_user_role_id')
        ) {
            return;
        }

        Schema::table('users', function (Blueprint $table): void {
            $table->foreignId('user_role_id')
                ->nullable()
                ->after('password')
                ->constrained('user_roles')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('users', 'user_role_id')) {
            return;
        }

        Schema::table('users', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('user_role_id');
        });
    }
};
