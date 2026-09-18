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
        $locales = ['en', 'ar', 'default', 'nl', 'tr', 'fr', 'de', 'es', 'zh_CN', 'pt_BR', 'ja', 'it', 'he', 'pl', 'fa', 'hi', 'uk', 'ru', 'vi', 'ko', 'bn', 'sv'];

        // 1. Create CMS Page: Authenticity
        $existingAuth = DB::table('cms_page_translations')->where('url_key', 'authenticity')->first();
        if (! $existingAuth) {
            $authPageId = DB::table('cms_pages')->insertGetId([
                'layout' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('cms_page_channels')->insert([
                'cms_page_id' => $authPageId,
                'channel_id' => 1,
            ]);

            $authHtml = <<<'HTML'
<div style="max-width:960px;margin:0 auto;padding:40px 20px;font-family:inherit;color:#4a2e35;line-height:1.7;">
    <div style="text-align:center;margin-bottom:40px;padding:32px 20px;background:linear-gradient(135deg,#fff8fb 0%,#ffeef5 100%);border-radius:24px;border:1px solid #f9d5e3;">
        <span style="display:inline-block;padding:6px 16px;background:#fff0f5;color:#ef789f;border-radius:999px;font-size:13px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">✦ 100% Genuine Guarantee ✦</span>
        <h1 style="font-size:32px;font-weight:800;color:#4a2e35;margin:16px 0 10px;">Authenticity Guarantee ♡</h1>
        <p style="font-size:16px;color:#80616a;max-width:640px;margin:0 auto;">At Kawaii Blessings, authenticity is our golden rule. Every blind box, plush, figure, and accessory in our collection is 100% genuine, licensed, and verified.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:24px;margin-bottom:40px;">
        <div style="background:#fff;border:1px solid #f2d7e0;border-radius:20px;padding:28px 24px;box-shadow:0 4px 16px rgba(239,120,159,0.06);">
            <div style="font-size:28px;margin-bottom:12px;">🌸</div>
            <h3 style="font-size:18px;font-weight:700;color:#4a2e35;margin-bottom:8px;">Direct & Licensed Sourcing</h3>
            <p style="font-size:14px;color:#7d5c66;">We work directly with authorized distributors and official brand partners across Japan and global designer toy studios including Sanrio, Pop Mart, Sonny Angel, Mofusand, and Chiikawa.</p>
        </div>

        <div style="background:#fff;border:1px solid #f2d7e0;border-radius:20px;padding:28px 24px;box-shadow:0 4px 16px rgba(239,120,159,0.06);">
            <div style="font-size:28px;margin-bottom:12px;">✨</div>
            <h3 style="font-size:18px;font-weight:700;color:#4a2e35;margin-bottom:8px;">Factory-Sealed Packaging</h3>
            <p style="font-size:14px;color:#7d5c66;">All mystery blind boxes and collectible figures are delivered brand-new, unopened, and in their original manufacturer packaging with holographic authenticity stickers intact.</p>
        </div>

        <div style="background:#fff;border:1px solid #f2d7e0;border-radius:20px;padding:28px 24px;box-shadow:0 4px 16px rgba(239,120,159,0.06);">
            <div style="font-size:28px;margin-bottom:12px;">🛡️</div>
            <h3 style="font-size:18px;font-weight:700;color:#4a2e35;margin-bottom:8px;">Zero Counterfeit Tolerance</h3>
            <p style="font-size:14px;color:#7d5c66;">We have a strict zero-tolerance policy against replicas and unverified goods. Every item undergoes quality inspection before being carefully packed for shipping.</p>
        </div>
    </div>

    <div style="background:#fff4f8;border-radius:20px;padding:28px;border-left:5px solid #ef789f;margin-bottom:32px;">
        <h4 style="font-size:16px;font-weight:700;color:#4a2e35;margin-bottom:6px;">Need Verification or Have Questions?</h4>
        <p style="font-size:14px;color:#7d5c66;margin:0;">If you ever have a question regarding a specific item or collection, our dedicated collector care team is always here to assist you at support@kawaiiblessings.com.</p>
    </div>
</div>
HTML;

            foreach ($locales as $loc) {
                DB::table('cms_page_translations')->insert([
                    'page_title' => '100% Authenticity Guarantee',
                    'url_key' => 'authenticity',
                    'html_content' => $authHtml,
                    'meta_title' => '100% Authenticity Guarantee | Kawaii Blessings',
                    'meta_description' => 'Learn about Kawaii Blessings authenticity guarantee. 100% genuine Japanese character goods, licensed Pop Mart, Sanrio, Sonny Angel, and collector toys in UAE.',
                    'meta_keywords' => 'Authenticity Guarantee, Genuine Japanese Merchandise, Sanrio, Pop Mart, Sonny Angel, Kawaii Blessings, UAE, Dubai',
                    'locale' => $loc,
                    'cms_page_id' => $authPageId,
                ]);
            }
        }

        // 2. Create CMS Page: Packaging
        $existingPack = DB::table('cms_page_translations')->where('url_key', 'packaging')->first();
        if (! $existingPack) {
            $packPageId = DB::table('cms_pages')->insertGetId([
                'layout' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('cms_page_channels')->insert([
                'cms_page_id' => $packPageId,
                'channel_id' => 1,
            ]);

            $packHtml = <<<'HTML'
<div style="max-width:960px;margin:0 auto;padding:40px 20px;font-family:inherit;color:#4a2e35;line-height:1.7;">
    <div style="text-align:center;margin-bottom:40px;padding:32px 20px;background:linear-gradient(135deg,#fff8fb 0%,#ffeef5 100%);border-radius:24px;border:1px solid #f9d5e3;">
        <span style="display:inline-block;padding:6px 16px;background:#fff0f5;color:#ef789f;border-radius:999px;font-size:13px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">📦 Collector-Grade Care 📦</span>
        <h1 style="font-size:32px;font-weight:800;color:#4a2e35;margin:16px 0 10px;">Kawaii Safe Packaging & Delivery ♡</h1>
        <p style="font-size:16px;color:#80616a;max-width:640px;margin:0 auto;">We understand how precious collector items and blind boxes are. Every order is packed with utmost love, protective cushioning, and delightful kawaii touches.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:24px;margin-bottom:40px;">
        <div style="background:#fff;border:1px solid #f2d7e0;border-radius:20px;padding:28px 24px;box-shadow:0 4px 16px rgba(239,120,159,0.06);">
            <div style="font-size:28px;margin-bottom:12px;">🫧</div>
            <h3 style="font-size:18px;font-weight:700;color:#4a2e35;margin-bottom:8px;">Multi-Layer Bubble Cushioning</h3>
            <p style="font-size:14px;color:#7d5c66;">Each blind box, plush, and acrylic charm is cushioned with premium bubble wrapping to ensure flawless box corners and zero impact during transit.</p>
        </div>

        <div style="background:#fff;border:1px solid #f2d7e0;border-radius:20px;padding:28px 24px;box-shadow:0 4px 16px rgba(239,120,159,0.06);">
            <div style="font-size:28px;margin-bottom:12px;">🎀</div>
            <h3 style="font-size:18px;font-weight:700;color:#4a2e35;margin-bottom:8px;">Delightful Unboxing</h3>
            <p style="font-size:14px;color:#7d5c66;">We want every unboxing to feel like opening a special present. Enjoy cute stickers, pastel tissue wrapping, and collector thank-you notes in every parcel.</p>
        </div>

        <div style="background:#fff;border:1px solid #f2d7e0;border-radius:20px;padding:28px 24px;box-shadow:0 4px 16px rgba(239,120,159,0.06);">
            <div style="font-size:28px;margin-bottom:12px;">🚚</div>
            <h3 style="font-size:18px;font-weight:700;color:#4a2e35;margin-bottom:8px;">Fast, Tracked UAE Delivery</h3>
            <p style="font-size:14px;color:#7d5c66;">All shipments within Dubai, Abu Dhabi, Sharjah, and all Emirates are dispatched via verified couriers with direct SMS tracking from our store to your door.</p>
        </div>
    </div>

    <div style="background:#fff4f8;border-radius:20px;padding:28px;border-left:5px solid #ef789f;margin-bottom:32px;">
        <h4 style="font-size:16px;font-weight:700;color:#4a2e35;margin-bottom:6px;">Damaged Box Protection</h4>
        <p style="font-size:14px;color:#7d5c66;margin:0;">In the rare event of damage in transit, reach out to our team within 48 hours of delivery with photos of the outer package and item for swift replacement assistance.</p>
    </div>
</div>
HTML;

            foreach ($locales as $loc) {
                DB::table('cms_page_translations')->insert([
                    'page_title' => 'Kawaii Safe Packaging & Delivery',
                    'url_key' => 'packaging',
                    'html_content' => $packHtml,
                    'meta_title' => 'Collector-Grade Safe Packaging & Delivery | Kawaii Blessings',
                    'meta_description' => 'Learn how Kawaii Blessings securely packages and ships blind boxes, plushies, and collector figures across the UAE with bubble cushioning and tamper-proof care.',
                    'meta_keywords' => 'Safe Packaging, Collector Box Protection, Blind Box Delivery, Kawaii Blessings, UAE, Dubai',
                    'locale' => $loc,
                    'cms_page_id' => $packPageId,
                ]);
            }
        }

        // 3. Update Theme Section 207 (Just Landed 4-row grid)
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
                    if (! is_array($data) || ! isset($data['html'])) {
                        continue;
                    }

                    $html = $data['html'];

                    if (stripos($html, 'Just Landed') !== false) {
                        // 1. Update fetch limit from 12 to 16 for 4 full rows
                        $html = preg_replace('/limit=(?:12|8|10)/i', 'limit=16', $html);

                        // 2. Replace column-flow slider CSS with 4-column multi-row grid
                        $gridCss = <<<'CSS'
.track {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    padding: 10px 2px 20px;
}

@media (max-width: 1024px) {
    .track {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }
}

@media (max-width: 640px) {
    .track {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }
}
CSS;

                        $html = preg_replace('/\.track\s*\{[^}]*grid-auto-flow\s*:\s*column[^}]*\}/is', $gridCss, $html);

                        if ($html !== $data['html']) {
                            $data['html'] = $html;
                            $raw = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                            $changed = true;
                        }
                    }
                }

                if ($changed) {
                    DB::table('theme_section_translations')
                        ->where('id', $row->id)
                        ->update([
                            'options' => $optsJson,
                            'draft_options' => $draftJson,
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
        // Safe no-op down migration
    }
};
