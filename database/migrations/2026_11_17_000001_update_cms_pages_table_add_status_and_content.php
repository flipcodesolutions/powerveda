<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('cms_pages', 'content')) {
                $table->longText('content')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('cms_pages', 'status')) {
                $table->boolean('status')->default(true)->after('slug');
            }
        });

        // Copy existing 'detail' data into 'content' if 'detail' column exists
        if (Schema::hasColumn('cms_pages', 'detail') && Schema::hasColumn('cms_pages', 'content')) {
            DB::statement('UPDATE cms_pages SET content = detail WHERE content IS NULL OR content = ""');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            if (Schema::hasColumn('cms_pages', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('cms_pages', 'content')) {
                $table->dropColumn('content');
            }
        });
    }
};
