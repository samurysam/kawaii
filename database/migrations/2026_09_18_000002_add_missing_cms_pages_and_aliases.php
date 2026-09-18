<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $locales = ['en', 'ar', 'default', 'nl', 'tr', 'fr', 'de', 'es', 'zh_CN', 'pt_BR', 'ja', 'it', 'he', 'pl', 'fa', 'hi', 'uk', 'ru', 'vi', 'ko', 'bn', 'sv'];

        // 1. CMS Page: authenticity-guarantee (Matching exact footer link)
        $existingAuth = DB::table('cms_page_translations')->where('url_key', 'authenticity-guarantee')->first();
        if (! $existingAuth) {
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

            $authPageId = DB::table('cms_pages')->insertGetId([
                'layout' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('cms_page_channels')->insert([
                'cms_page_id' => $authPageId,
                'channel_id' => 1,
            ]);

            foreach ($locales as $loc) {
                DB::table('cms_page_translations')->insert([
                    'page_title' => 'Authenticity Guarantee',
                    'url_key' => 'authenticity-guarantee',
                    'html_content' => $authHtml,
                    'meta_title' => 'Authenticity Guarantee | Kawaii Blessings',
                    'meta_description' => 'Learn about Kawaii Blessings authenticity guarantee. 100% genuine Japanese character goods, licensed Pop Mart, Sanrio, Sonny Angel, and collector toys in UAE.',
                    'meta_keywords' => 'Authenticity Guarantee, Genuine Japanese Merchandise, Sanrio, Pop Mart, Sonny Angel, Kawaii Blessings, UAE, Dubai',
                    'locale' => $loc,
                    'cms_page_id' => $authPageId,
                ]);
            }
        }

        // 2. CMS Page: size-guide
        $existingSize = DB::table('cms_page_translations')->where('url_key', 'size-guide')->first();
        if (! $existingSize) {
            $sizeHtml = <<<'HTML'
<div style="max-width:960px;margin:0 auto;padding:40px 20px;font-family:inherit;color:#4a2e35;line-height:1.7;">
    <div style="text-align:center;margin-bottom:40px;padding:32px 20px;background:linear-gradient(135deg,#fff8fb 0%,#ffeef5 100%);border-radius:24px;border:1px solid #f9d5e3;">
        <span style="display:inline-block;padding:6px 16px;background:#fff0f5;color:#ef789f;border-radius:999px;font-size:13px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">📏 Sizing & Dimensions Guide 📏</span>
        <h1 style="font-size:32px;font-weight:800;color:#4a2e35;margin:16px 0 10px;">Kawaii Size Guide ♡</h1>
        <p style="font-size:16px;color:#80616a;max-width:640px;margin:0 auto;">Find the perfect fit for plushies, blind box figures, apparel, and bags.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:24px;margin-bottom:40px;">
        <div style="background:#fff;border:1px solid #f2d7e0;border-radius:20px;padding:28px 24px;box-shadow:0 4px 16px rgba(239,120,159,0.06);">
            <div style="font-size:28px;margin-bottom:12px;">🧸</div>
            <h3 style="font-size:18px;font-weight:700;color:#4a2e35;margin-bottom:8px;">Plushies & Bag Charms</h3>
            <p style="font-size:14px;color:#7d5c66;"><strong>Mascot / Bag Charm:</strong> 8 – 14 cm<br><strong>Standard Plush:</strong> 20 – 30 cm<br><strong>Cuddle Giant Plush:</strong> 40 – 60 cm</p>
        </div>

        <div style="background:#fff;border:1px solid #f2d7e0;border-radius:20px;padding:28px 24px;box-shadow:0 4px 16px rgba(239,120,159,0.06);">
            <div style="font-size:28px;margin-bottom:12px;">🎁</div>
            <h3 style="font-size:18px;font-weight:700;color:#4a2e35;margin-bottom:8px;">Blind Box Figures</h3>
            <p style="font-size:14px;color:#7d5c66;"><strong>Mini Figures:</strong> 6 – 9 cm tall<br><strong>Labubu / Vinyl Plush:</strong> 15 – 18 cm<br><strong>Pop Mart Mega:</strong> 400% (28 cm) & 1000% (70 cm)</p>
        </div>

        <div style="background:#fff;border:1px solid #f2d7e0;border-radius:20px;padding:28px 24px;box-shadow:0 4px 16px rgba(239,120,159,0.06);">
            <div style="font-size:28px;margin-bottom:12px;">👜</div>
            <h3 style="font-size:18px;font-weight:700;color:#4a2e35;margin-bottom:8px;">Bags & Totes</h3>
            <p style="font-size:14px;color:#7d5c66;"><strong>Canvas Tote:</strong> 38 × 34 cm<br><strong>Mini Crossbody:</strong> 20 × 16 cm<br><strong>Backpacks:</strong> 42 × 30 × 14 cm</p>
        </div>
    </div>
</div>
HTML;

            $sizePageId = DB::table('cms_pages')->insertGetId([
                'layout' => 'default',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('cms_page_channels')->insert([
                'cms_page_id' => $sizePageId,
                'channel_id' => 1,
            ]);

            foreach ($locales as $loc) {
                DB::table('cms_page_translations')->insert([
                    'page_title' => 'Size Guide',
                    'url_key' => 'size-guide',
                    'html_content' => $sizeHtml,
                    'meta_title' => 'Kawaii Size Guide | Kawaii Blessings',
                    'meta_description' => 'Sizing and dimension guide for plushies, blind box figures, bags, and kawaii fashion.',
                    'meta_keywords' => 'Size Guide, Plushie Dimensions, Blind Box Height, Kawaii Blessings',
                    'locale' => $loc,
                    'cms_page_id' => $sizePageId,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
