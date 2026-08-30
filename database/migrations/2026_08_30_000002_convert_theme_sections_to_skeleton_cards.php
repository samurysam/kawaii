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
        $skeletonCats = str_repeat('<div class="card kb-cat-skeleton" aria-hidden="true"><div class="media"><div class="kb-shimmer"></div></div><div class="name"><div class="kb-shimmer-text"></div></div></div>', 8);
        $skeletonTrends = str_repeat('<div class="trend kb-trend-skeleton" aria-hidden="true"><div class="img"><div class="kb-shimmer" style="width:100%;height:100%;border-radius:50%;"></div></div><div class="kb-shimmer-text" style="width:60%;height:10px;margin:auto;"></div></div>', 6);
        $skeletonProducts = str_repeat('<div class="product kb-prod-skeleton" aria-hidden="true"><div class="pm"><div class="kb-shimmer" style="width:100%;height:100%;"></div></div><div class="pi"><div class="kb-shimmer-text" style="width:80%;height:12px;"></div><div class="kb-shimmer-text" style="width:40%;height:12px;margin-top:6px;"></div></div></div>', 4);
        $shimmerCss = "\n.kb-cat-skeleton,.kb-trend-skeleton,.kb-prod-skeleton{pointer-events:none!important;border-color:rgba(238,205,215,0.6)!important;}\n.kb-shimmer{width:100%;height:100%;background:linear-gradient(90deg,#fff0f4 0%,#ffe0ea 50%,#fff0f4 100%);background-size:200% 100%;animation:kbShimmerPulse 1.8s ease-in-out infinite;border-radius:10px;}\n.kb-shimmer-text{background:linear-gradient(90deg,#fce0e8 0%,#f7cad6 50%,#fce0e8 100%);background-size:200% 100%;animation:kbShimmerPulse 1.8s ease-in-out infinite;border-radius:6px;}\n@keyframes kbShimmerPulse{0%{background-position:200% 0;}100%{background-position:-200% 0;}}\n";

        // 1. Scrub theme_section_translations
        if (Schema::hasTable('theme_section_translations')) {
            $rows = DB::table('theme_section_translations')->get();

            foreach ($rows as $row) {
                $changed = false;
                $optsJson = $row->options;
                $draftJson = $row->draft_options;

                foreach (['options' => &$optsJson, 'draft_options' => &$draftJson] as $field => &$raw) {
                    if (! $raw) {
                        continue;
                    }
                    $data = is_string($raw) ? json_decode($raw, true) : $raw;
                    if (! is_array($data)) {
                        continue;
                    }

                    if (isset($data['html'])) {
                        $html = $data['html'];

                        // Remove all Bagisto
                        $html = preg_replace('/bagisto/i', 'Kawaii Blessings', $html);

                        // Replace loading text with skeleton cards
                        $html = preg_replace('/<div class=[\"\\\\\']+msg[\"\\\\\']+>\s*Loading categories[^<]*<\/div>/iu', $skeletonCats, $html);
                        $html = preg_replace('/<div class=[\"\\\\\']+msg[\"\\\\\']+>\s*Loading collections[^<]*<\/div>/iu', $skeletonTrends, $html);
                        $html = preg_replace('/<div class=[\"\\\\\']+msg[\"\\\\\']+>\s*Loading products[^<]*<\/div>/iu', $skeletonProducts, $html);

                        // Inject shimmer CSS into <style> if needed
                        if (! str_contains($html, 'kbShimmerPulse') && str_contains($html, '</style>')) {
                            $html = str_replace('</style>', $shimmerCss.'</style>', $html);
                        }

                        if ($html !== $data['html']) {
                            $data['html'] = $html;
                            $raw = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                            $changed = true;
                        }
                    }
                }

                if ($changed) {
                    DB::table('theme_section_translations')->where('id', $row->id)->update([
                        'options' => $optsJson,
                        'draft_options' => $draftJson,
                    ]);
                }
            }
        }

        // 2. Scrub theme_customization_translations if exists
        if (Schema::hasTable('theme_customization_translations')) {
            $rows = DB::table('theme_customization_translations')->get();

            foreach ($rows as $row) {
                $raw = $row->options;
                if (! $raw) {
                    continue;
                }
                $data = is_string($raw) ? json_decode($raw, true) : $raw;
                if (! is_array($data)) {
                    continue;
                }

                if (isset($data['html'])) {
                    $html = $data['html'];
                    $html = preg_replace('/bagisto/i', 'Kawaii Blessings', $html);
                    $html = preg_replace('/<div class=[\"\\\\\']+msg[\"\\\\\']+>\s*Loading categories[^<]*<\/div>/iu', $skeletonCats, $html);
                    $html = preg_replace('/<div class=[\"\\\\\']+msg[\"\\\\\']+>\s*Loading collections[^<]*<\/div>/iu', $skeletonTrends, $html);
                    $html = preg_replace('/<div class=[\"\\\\\']+msg[\"\\\\\']+>\s*Loading products[^<]*<\/div>/iu', $skeletonProducts, $html);

                    if (! str_contains($html, 'kbShimmerPulse') && str_contains($html, '</style>')) {
                        $html = str_replace('</style>', $shimmerCss.'</style>', $html);
                    }

                    $data['html'] = $html;
                    DB::table('theme_customization_translations')->where('id', $row->id)->update([
                        'options' => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                    ]);
                }
            }
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
