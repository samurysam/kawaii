<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Scrub theme_section_translations
        if (Schema::hasTable('theme_section_translations')) {
            $rows = DB::table('theme_section_translations')->get(['id', 'options', 'draft_options']);

            foreach ($rows as $row) {
                $opts = $row->options ? preg_replace('/bagisto/i', 'Kawaii Blessings', $row->options) : null;
                $draft = $row->draft_options ? preg_replace('/bagisto/i', 'Kawaii Blessings', $row->draft_options) : null;

                if ($opts) {
                    $opts = str_replace(
                        ['Loading categories from Kawaii Blessings…', 'Loading categories from Kawaii Blessings...', 'Loading categories from Bagisto…', 'Loading categories from Bagisto...'],
                        'Loading categories…',
                        $opts
                    );
                }

                if ($draft) {
                    $draft = str_replace(
                        ['Loading categories from Kawaii Blessings…', 'Loading categories from Kawaii Blessings...', 'Loading categories from Bagisto…', 'Loading categories from Bagisto...'],
                        'Loading categories…',
                        $draft
                    );
                }

                DB::table('theme_section_translations')->where('id', $row->id)->update([
                    'options' => $opts,
                    'draft_options' => $draft,
                ]);
            }
        }

        // 2. Scrub theme_customization_translations if exists
        if (Schema::hasTable('theme_customization_translations')) {
            $rows = DB::table('theme_customization_translations')->get(['id', 'options']);

            foreach ($rows as $row) {
                $opts = $row->options ? preg_replace('/bagisto/i', 'Kawaii Blessings', $row->options) : null;

                if ($opts) {
                    $opts = str_replace(
                        ['Loading categories from Kawaii Blessings…', 'Loading categories from Kawaii Blessings...', 'Loading categories from Bagisto…', 'Loading categories from Bagisto...'],
                        'Loading categories…',
                        $opts
                    );
                }

                DB::table('theme_customization_translations')->where('id', $row->id)->update([
                    'options' => $opts,
                ]);
            }
        }

        // 3. Update channel_translations SEO and Branding
        if (Schema::hasTable('channel_translations')) {
            $homeSeo = json_encode([
                'meta_title' => 'Kawaii Blessings — Authentic Kawaii Merchandise & Collectibles | Powered by KeynoStore',
                'meta_keywords' => 'Kawaii Blessings, KeynoStore, kawaii plushies UAE, blind box Dubai, Sanrio UAE, Sonny Angel, Popmart UAE, kawaii collectibles',
                'meta_description' => 'Shop 100% authentic plushies, blind boxes, stationery, popmart and collectibles in UAE at Kawaii Blessings. Powered by KeynoStore.',
            ]);

            DB::table('channel_translations')->where('channel_id', 1)->update([
                'name' => 'Kawaii Blessings',
                'logo_alt' => 'Kawaii Blessings — Powered by KeynoStore',
                'home_seo' => $homeSeo,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No destructive reverse needed
    }
};
