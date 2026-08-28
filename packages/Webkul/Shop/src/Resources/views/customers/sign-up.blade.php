<!-- SEO Meta Content -->
@push('meta')
    <meta
        name="description"
        content="@lang('shop::app.customers.signup-form.page-title')"
    />

    <meta
        name="keywords"
        content="@lang('shop::app.customers.signup-form.page-title')"
    />
@endPush

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700;800&family=Nunito+Sans:wght@400;600;700;800;900&display=swap');

    :root {
        --kb-bg: #fff9fb;
        --kb-primary: #f58fb0;
        --kb-primary-2: #ed5287;
        --kb-primary-3: #ffd6e3;
        --kb-text-dark: #382229;
        --kb-text-body: #5a3e47;
        --kb-text-soft: #846671;
        --kb-border: #f1d5df;
        --kb-input-border: #ebd3de;
        --kb-shadow: 0 18px 50px rgba(226, 116, 157, 0.12);
        --kb-radius-xl: 44px;
        --kb-radius-lg: 36px;
        --kb-radius-md: 20px;
        --kb-radius-sm: 14px;
        --kb-radius-pill: 999px;
    }

    * {
        box-sizing: border-box;
    }

    /* Accessibility skip link - hidden visually unless focused */
    .skip-to-main-content-link,
    a[href="#main"].skip-to-main,
    .skip-to-main {
        position: absolute !important;
        top: -9999px !important;
        left: -9999px !important;
        width: 1px !important;
        height: 1px !important;
        overflow: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }
    .skip-to-main-content-link:focus,
    a[href="#main"].skip-to-main:focus,
    .skip-to-main:focus {
        top: 10px !important;
        left: 10px !important;
        width: auto !important;
        height: auto !important;
        padding: 10px 18px !important;
        background: #ed5287 !important;
        color: #fff !important;
        border-radius: 8px !important;
        z-index: 99999 !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }

    .kb-register-page {
        min-height: 100vh;
        background:
            radial-gradient(circle at 10% 12%, rgba(255, 214, 227, 0.50) 0%, transparent 28%),
            radial-gradient(circle at 90% 15%, rgba(255, 214, 227, 0.55) 0%, transparent 26%),
            radial-gradient(circle at 50% 85%, rgba(255, 230, 240, 0.45) 0%, transparent 35%),
            linear-gradient(180deg, #fff7fa 0%, #ffedf4 50%, #fff4f8 100%);
        padding: 36px 24px 48px;
        position: relative;
        overflow: hidden;
        font-family: 'Fredoka', 'Nunito Sans', sans-serif;
    }

    /* Ambient floating symbols */
    .kb-floating-symbol {
        position: absolute;
        pointer-events: none;
        user-select: none;
        animation: kbFloat 6s ease-in-out infinite;
        z-index: 1;
    }

    .kb-floating-symbol.s1 { top: 85px; left: 45px; font-size: 24px; color: #f7a4be; animation-delay: 0s; }
    .kb-floating-symbol.s2 { top: 185px; left: 30px; font-size: 32px; color: #f2628e; animation-delay: 1.2s; }
    .kb-floating-symbol.s3 { top: 305px; left: 50px; font-size: 24px; color: #fca8c2; animation-delay: 2.4s; }
    .kb-floating-symbol.s4 { top: 480px; left: 85px; font-size: 26px; color: #f2628e; animation-delay: 0.5s; }
    .kb-floating-symbol.s5 { top: 110px; right: 45px; font-size: 28px; color: #fca8c2; animation-delay: 0.8s; }
    .kb-floating-symbol.s6 { top: 275px; right: 35px; font-size: 30px; color: #f795b5; animation-delay: 2s; }
    .kb-floating-symbol.s7 { top: 440px; right: 55px; font-size: 24px; color: #f2628e; animation-delay: 1.6s; }
    .kb-floating-symbol.s8 { bottom: 130px; right: 65px; font-size: 28px; color: #fab3cb; animation-delay: 3s; }

    @keyframes kbFloat {
        0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.75; }
        50% { transform: translateY(-12px) rotate(5deg); opacity: 1; }
    }

    .kb-register-shell {
        width: min(1180px, 100%);
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1.15fr;
        gap: 38px;
        align-items: start;
        position: relative;
        z-index: 2;
    }

    /* LEFT COLUMN */
    .kb-left-panel {
        padding: 4px 12px 10px;
        position: relative;
    }

    .kb-logo-wrap {
        margin-bottom: 24px;
        display: inline-block;
    }

    .kb-logo-wrap img {
        display: block;
        width: 195px;
        max-width: 100%;
        height: auto;
    }

    .kb-left-copy {
        max-width: 440px;
        margin: 0 auto;
        text-align: center;
    }

    .kb-hero-title {
        margin: 0;
        color: var(--kb-text-dark);
        font-size: clamp(44px, 5.2vw, 68px);
        line-height: 1.0;
        font-weight: 800;
        letter-spacing: -0.03em;
        font-family: 'Fredoka', 'Arial Rounded MT Bold', sans-serif;
    }

    .kb-hero-title .pink {
        color: #ff4785;
        -webkit-text-stroke: 2px #000000;
        text-shadow: 
            -1.5px -1.5px 0 #000000,
             1.5px -1.5px 0 #000000,
            -1.5px  1.5px 0 #000000,
             1.5px  1.5px 0 #000000;
        paint-order: stroke fill;
    }

    .kb-ribbon-divider {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin: 18px auto 16px;
        max-width: 280px;
    }

    .kb-ribbon-divider .kb-dash-line {
        flex: 1;
        border-top: 2px dashed #f6cbd8;
        height: 0;
    }

    .kb-ribbon-divider .kb-bow-icon {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kb-left-copy p {
        margin: 0 auto;
        max-width: 380px;
        color: var(--kb-text-body);
        font-size: 16.5px;
        line-height: 1.6;
        font-weight: 600;
    }

    /* SCENE ARTWORK */
    .kb-scene {
        margin: 18px auto 22px;
        width: 100%;
        max-width: 470px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kb-scene svg {
        width: 100%;
        height: auto;
        display: block;
    }

    /* TRUST STRIP */
    .kb-trust-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        background: rgba(255, 255, 255, 0.90);
        border: 2px dashed #f6cbd8;
        border-radius: 20px;
        padding: 14px 10px;
        box-shadow: 0 10px 24px rgba(242, 175, 198, 0.10);
    }

    .kb-trust-item {
        text-align: center;
        padding: 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .kb-trust-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 6px;
    }

    .kb-trust-item strong {
        display: block;
        font-size: 13px;
        line-height: 1.25;
        font-weight: 800;
        color: var(--kb-text-dark);
        font-family: 'Fredoka', sans-serif;
    }

    .kb-trust-item strong.pink {
        color: var(--kb-primary-2);
    }

    .kb-trust-item span {
        display: block;
        font-size: 12px;
        color: var(--kb-text-dark);
        font-weight: 700;
        margin-top: 1px;
    }

    /* RIGHT COLUMN - FORM PANEL */
    .kb-form-panel {
        background: rgba(255, 255, 255, 0.52);
        border: 2px solid #f9e2eb;
        border-radius: var(--kb-radius-xl);
        box-shadow: 0 20px 60px rgba(245, 143, 176, 0.14);
        padding: 16px;
    }

    .kb-form-card {
        background: #ffffff;
        border: 1.5px solid #f5d6e2;
        border-radius: var(--kb-radius-lg);
        width: 100%;
        padding: 46px 44px 38px;
        position: relative;
    }

    /* Top Medallion Badge */
    .kb-card-medallion {
        position: absolute;
        top: -34px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        z-index: 10;
    }

    .kb-medallion-sparkle {
        font-size: 20px;
        color: #f7a4be;
        user-select: none;
        letter-spacing: 3px;
        filter: drop-shadow(0 2px 4px rgba(247,164,190,0.3));
    }

    .kb-medallion-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(180deg, #ffe5ee 0%, #fff0f5 100%);
        border: 2px dashed #f2b3c7;
        box-shadow: 0 10px 24px rgba(237, 82, 135, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .kb-medallion-bow {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kb-medallion-heart {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 4px;
    }

    .kb-form-header {
        text-align: center;
        padding-top: 18px;
        margin-bottom: 24px;
    }

    .kb-form-title {
        margin: 0;
        color: var(--kb-text-dark);
        font-size: clamp(32px, 3.4vw, 46px);
        line-height: 1.12;
        font-weight: 800;
        letter-spacing: -0.03em;
        font-family: 'Fredoka', 'Arial Rounded MT Bold', sans-serif;
    }

    .kb-form-title .pink {
        color: var(--kb-primary-2);
    }

    .kb-title-sep {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        margin: 14px auto 12px;
        max-width: 240px;
    }

    .kb-title-sep .line {
        flex: 1;
        height: 1px;
        background: #f1d4df;
    }

    .kb-title-sep .heart-icon {
        color: var(--kb-primary-2);
        font-size: 16px;
    }

    .kb-form-desc {
        margin: 0 auto;
        max-width: 420px;
        color: #70525d;
        font-size: 15.5px;
        line-height: 1.55;
        font-weight: 600;
    }

    /* FORM GRID & INPUTS */
    .kb-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px 16px;
    }

    .kb-field {
        margin-bottom: 16px;
    }

    .kb-field.full {
        grid-column: 1 / -1;
    }

    .kb-label {
        display: block;
        margin-bottom: 8px;
        font-size: 15px;
        font-weight: 700;
        color: #3e262e;
        font-family: 'Fredoka', sans-serif;
    }

    .kb-input-wrap {
        position: relative;
    }

    .kb-input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #bfa1ac;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }

    .kb-input {
        width: 100%;
        height: 56px;
        border: 1.5px solid var(--kb-input-border);
        background: #ffffff;
        border-radius: 14px;
        padding: 0 16px 0 48px;
        font-size: 15px;
        color: #4a3138;
        font-family: 'Nunito Sans', sans-serif;
        font-weight: 600;
        transition: all .2s ease;
        outline: none;
    }

    .kb-input:focus {
        border-color: var(--kb-primary);
        box-shadow: 0 0 0 4px rgba(245, 143, 176, 0.15);
    }

    .kb-input::placeholder {
        color: #bfa1ac;
        font-size: 14.5px;
        font-weight: 500;
    }

    .kb-input-wrap.has-toggle .kb-input {
        padding-right: 48px;
    }

    .kb-password-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: 0;
        padding: 6px;
        cursor: pointer;
        color: #bfa1ac;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color .2s ease;
    }

    .kb-password-toggle:hover {
        color: var(--kb-primary-2);
    }

    /* SAFETY BANNER */
    .kb-safety-banner {
        margin: 10px 0 20px;
        background: linear-gradient(135deg, #fff5f8 0%, #ffedf4 100%);
        border: 1.5px solid #f6d2df;
        border-radius: 16px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .kb-safety-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .kb-safety-icon {
        flex-shrink: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kb-safety-text strong {
        display: block;
        font-size: 13.5px;
        line-height: 1.3;
        color: #3e262e;
        font-weight: 800;
        font-family: 'Fredoka', sans-serif;
    }

    .kb-safety-text span {
        font-size: 12.5px;
        color: #7b5f6a;
        font-weight: 600;
        font-family: 'Nunito Sans', sans-serif;
    }

    .kb-safety-sparkle {
        flex-shrink: 0;
        color: #f79ab8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* SUBMIT BUTTON */
    .kb-btn-register {
        width: 100%;
        height: 64px;
        border: 0;
        border-radius: var(--kb-radius-pill);
        background: linear-gradient(135deg, #f78bb0 0%, #eb5287 100%);
        color: #ffffff;
        font-size: 20px;
        font-weight: 800;
        font-family: 'Fredoka', sans-serif;
        cursor: pointer;
        box-shadow: 0 14px 30px rgba(235, 82, 135, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
    }

    .kb-btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 36px rgba(235, 82, 135, 0.42);
        filter: brightness(1.03);
    }

    .kb-btn-register:active {
        transform: translateY(0);
    }

    .kb-register-sparkles {
        display: inline-block;
        vertical-align: middle;
    }

    /* BOTTOM DIVIDER & LOGIN NOTE */
    .kb-bottom-divider {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        margin: 22px auto 16px;
        max-width: 260px;
    }

    .kb-bottom-divider .line {
        flex: 1;
        height: 1px;
        background: #f1d4df;
    }

    .kb-bottom-divider .bow-icon {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kb-signin-prompt {
        text-align: center;
        font-size: 16px;
        color: #6b4f59;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-family: 'Nunito Sans', sans-serif;
    }

    .kb-signin-link {
        color: var(--kb-primary-2);
        font-weight: 800;
        text-decoration: underline;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: color .2s ease;
    }

    .kb-signin-link:hover {
        color: #d83d73;
    }

    .kb-circle-arrow {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .kb-error {
        display: block;
        margin-top: 6px;
        color: #e04b7b;
        font-size: 13px;
        font-weight: 700;
        font-family: 'Nunito Sans', sans-serif;
    }

    /* FOOTER */
    .kb-page-footer {
        margin-top: 40px;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .kb-cloud-trim {
        width: 100%;
        max-width: 1000px;
        margin: 0 auto -10px;
        opacity: 0.6;
        pointer-events: none;
    }

    .kb-cloud-trim svg {
        width: 100%;
        height: 36px;
        display: block;
    }

    .kb-footer-icons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 24px;
        margin-bottom: 12px;
    }

    .kb-footer-icons span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .kb-copyright {
        font-size: 13px;
        color: #846772;
        line-height: 1.6;
        margin: 0;
        font-family: 'Nunito Sans', sans-serif;
        font-weight: 600;
    }

    .kb-copyright .pink {
        color: var(--kb-primary-2);
        font-weight: 700;
    }

    .kb-copyright .heart {
        color: var(--kb-primary-2);
    }

    /* Responsive */
    @media (max-width: 1080px) {
        .kb-register-shell {
            grid-template-columns: 1fr;
            max-width: 600px;
        }

        .kb-left-panel {
            padding: 10px 10px 20px;
        }
    }

    @media (max-width: 640px) {
        .kb-register-page {
            padding: 20px 12px 36px;
        }

        .kb-form-card {
            padding: 40px 20px 28px;
            border-radius: 26px;
        }

        .kb-form-panel {
            padding: 8px;
            border-radius: 30px;
        }

        .kb-form-grid {
            grid-template-columns: 1fr;
        }

        .kb-hero-title {
            font-size: 42px;
        }

        .kb-form-title {
            font-size: 32px;
        }

        .kb-trust-strip {
            grid-template-columns: 1fr 1fr;
            gap: 10px 8px;
        }

        .kb-btn-register {
            height: 56px;
            font-size: 17.5px;
        }
    }


    /* ================================================================
       KAWAII BLESSINGS — DREAMLAND 1:1 REPLICA / ANIMATION OVERRIDES
       ================================================================ */

    .kb-register-page {
        --kb-mouse-x: 0px;
        --kb-mouse-y: 0px;
        min-height: 100dvh;
        isolation: isolate;
        overflow: hidden;
        padding: 28px 24px 54px;
        background:
            radial-gradient(circle at 4% 7%, rgba(255,255,255,.92) 0 2px, transparent 3px),
            radial-gradient(circle at 91% 14%, rgba(255,255,255,.82) 0 2px, transparent 3px),
            radial-gradient(circle at 50% 8%, rgba(255,255,255,.50), transparent 24%),
            radial-gradient(circle at 12% 44%, rgba(255,200,220,.34), transparent 24%),
            radial-gradient(circle at 90% 38%, rgba(252,189,215,.36), transparent 27%),
            linear-gradient(180deg, #ffeef4 0%, #fff4f8 27%, #ffeaf2 64%, #fff1f6 100%);
    }

    .kb-register-page::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        opacity: .72;
        background-image:
            radial-gradient(circle, rgba(255,255,255,.95) 0 1.1px, transparent 1.8px),
            radial-gradient(circle, rgba(247,147,180,.36) 0 1.1px, transparent 1.8px);
        background-size: 61px 61px, 97px 97px;
        background-position: 7px 18px, 37px 42px;
        animation: kbStarField 24s linear infinite;
    }

    .kb-register-page::after {
        content: "";
        position: absolute;
        z-index: 0;
        width: 640px;
        height: 640px;
        left: 50%;
        top: 46%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        pointer-events: none;
        background: radial-gradient(circle, rgba(255,255,255,.42), rgba(255,221,234,.12) 49%, transparent 72%);
        filter: blur(14px);
        animation: kbAura 8s ease-in-out infinite;
    }

    .kb-dream-sky {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        overflow: hidden;
    }

    .kb-sky-cloud {
        position: absolute;
        display: block;
        width: 150px;
        height: 48px;
        border-radius: 999px;
        background: linear-gradient(180deg, rgba(255,255,255,.97), rgba(255,247,251,.91));
        border: 1px solid rgba(255,220,233,.62);
        box-shadow:
            0 13px 30px rgba(221,117,155,.08),
            inset 0 -7px 15px rgba(255,222,234,.16);
        filter: drop-shadow(0 8px 18px rgba(234,145,178,.08));
        will-change: transform;
    }

    .kb-sky-cloud::before,
    .kb-sky-cloud::after {
        content: "";
        position: absolute;
        bottom: 10px;
        border-radius: 50%;
        background: inherit;
        border: inherit;
        border-bottom-color: transparent;
        box-shadow: inset 0 -5px 12px rgba(255,222,234,.10);
    }

    .kb-sky-cloud::before {
        width: 64px;
        height: 64px;
        left: 21px;
    }

    .kb-sky-cloud::after {
        width: 84px;
        height: 84px;
        right: 18px;
        bottom: 7px;
    }

    .kb-cloud-1 { width: 178px; height: 52px; top: 50px; left: 31%; opacity: .82; animation: kbCloudA 10s ease-in-out infinite; }
    .kb-cloud-2 { width: 230px; height: 60px; top: 38px; right: -34px; opacity: .88; animation: kbCloudB 12s ease-in-out -2s infinite; }
    .kb-cloud-3 { width: 130px; height: 40px; top: 154px; right: 15%; opacity: .58; animation: kbCloudC 9s ease-in-out -4s infinite; }
    .kb-cloud-4 { width: 116px; height: 38px; top: 102px; left: -32px; opacity: .68; animation: kbCloudB 13s ease-in-out -7s infinite; }
    .kb-cloud-5 { width: 145px; height: 42px; top: 43%; left: -64px; opacity: .38; animation: kbCloudA 15s ease-in-out -3s infinite; }
    .kb-cloud-6 { width: 156px; height: 45px; top: 51%; right: -72px; opacity: .42; animation: kbCloudC 14s ease-in-out -5s infinite; }
    .kb-cloud-7 { width: 106px; height: 34px; top: 73%; left: 42%; opacity: .30; animation: kbCloudA 16s ease-in-out -8s infinite; }

    .kb-sky-sparkle,
    .kb-sky-heart {
        position: absolute;
        z-index: 1;
        user-select: none;
        will-change: transform, opacity;
        filter: drop-shadow(0 3px 6px rgba(238,91,141,.16));
    }

    .kb-sky-sparkle {
        color: #fff;
        text-shadow: 0 0 12px rgba(255,255,255,.95), 0 0 18px rgba(246,147,180,.30);
        animation: kbTwinkle 2.8s ease-in-out infinite;
    }

    .kb-star-1 { left: 6%; top: 6%; font-size: 24px; animation-delay: -.2s; }
    .kb-star-2 { left: 38%; top: 4%; font-size: 18px; animation-delay: -1.1s; }
    .kb-star-3 { right: 12%; top: 10%; font-size: 28px; animation-delay: -1.7s; }
    .kb-star-4 { right: 7%; top: 46%; font-size: 17px; animation-delay: -.8s; }
    .kb-star-5 { left: 4%; top: 55%; font-size: 21px; animation-delay: -2s; }
    .kb-star-6 { left: 43%; top: 79%; font-size: 16px; animation-delay: -.5s; }

    .kb-sky-heart {
        color: #f27ba3;
        opacity: .64;
        animation: kbHeartDrift 5.8s ease-in-out infinite;
    }
    .kb-heart-1 { left: 2%; top: 18%; font-size: 28px; animation-delay: -1s; }
    .kb-heart-2 { left: 39%; top: 22%; font-size: 24px; color: #ce9ae9; animation-delay: -2.2s; }
    .kb-heart-3 { right: 3%; top: 30%; font-size: 25px; animation-delay: -3.2s; }
    .kb-heart-4 { right: 24%; top: 79%; font-size: 18px; animation-delay: -.4s; }

    .kb-bottom-cloud-bank {
        position: absolute;
        left: -5%;
        right: -5%;
        bottom: -26px;
        height: 104px;
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        opacity: .72;
        filter: drop-shadow(0 -4px 14px rgba(239,159,188,.06));
    }

    .kb-bottom-cloud-bank span {
        flex: 0 0 auto;
        width: 180px;
        height: 72px;
        border-radius: 50% 50% 20% 20%;
        background: linear-gradient(180deg, rgba(255,255,255,.96), rgba(255,247,251,.93));
        border: 1px solid rgba(250,216,229,.7);
        margin-left: -54px;
    }

    .kb-bank-back { bottom: 2px; opacity: .34; transform: scale(1.08); animation: kbCloudBank 14s ease-in-out infinite; }
    .kb-bank-front { bottom: -46px; opacity: .82; animation: kbCloudBank 11s ease-in-out -4s infinite reverse; }

    .kb-register-shell {
        width: min(1115px, 100%);
        grid-template-columns: minmax(0, .94fr) minmax(0, 1.06fr);
        gap: 22px;
        align-items: start;
        z-index: 3;
    }

    .kb-left-panel {
        min-width: 0;
        padding: 8px 14px 8px;
    }

    .kb-logo-wrap {
        margin: 2px 0 25px 40px;
        position: relative;
        z-index: 5;
        animation: kbLogoEntrance .85s cubic-bezier(.2,.8,.2,1) both,
                   kbLogoFloat 5s ease-in-out 1s infinite;
        transform-origin: center;
    }

    .kb-logo-wrap img {
        width: 178px;
        filter: drop-shadow(0 9px 16px rgba(226,98,145,.12));
        transition: filter .25s ease;
    }

    .kb-logo-wrap:hover img {
        filter: drop-shadow(0 12px 20px rgba(226,98,145,.22));
    }

    .kb-left-copy {
        max-width: 440px;
        position: relative;
        z-index: 4;
    }

    .kb-hero-title {
        font-size: clamp(50px, 5vw, 68px);
        line-height: .96;
        letter-spacing: -.035em;
        text-shadow: 0 2px 0 rgba(255,255,255,.84);
        animation: kbTitleEntrance .9s .08s cubic-bezier(.18,.82,.2,1) both;
    }

    .kb-hero-title .pink {
        display: inline-block;
        color: #ff4785;
        -webkit-text-stroke: 2px #000000;
        text-shadow: 
            -1.5px -1.5px 0 #000000,
             1.5px -1.5px 0 #000000,
            -1.5px  1.5px 0 #000000,
             1.5px  1.5px 0 #000000,
             0 4px 12px rgba(0,0,0,.22);
        paint-order: stroke fill;
        animation: kbPinkWordGlow 4s ease-in-out 1.1s infinite;
    }

    .kb-ribbon-divider {
        max-width: 230px;
        margin: 18px auto 14px;
        animation: kbFadeUp .75s .24s both;
    }

    .kb-ribbon-divider .kb-dash-line {
        border-top-color: #f49aba;
        opacity: .78;
    }

    .kb-ribbon-divider .kb-bow-icon {
        animation: kbBowBounce 3.6s ease-in-out 1s infinite;
        filter: drop-shadow(0 5px 7px rgba(237,82,135,.16));
    }

    .kb-left-copy p {
        max-width: 390px;
        font-size: 16px;
        line-height: 1.58;
        animation: kbFadeUp .8s .32s both;
    }

    .kb-scene {
        position: relative;
        z-index: 4;
        max-width: 500px;
        margin: 15px auto 20px;
        filter: drop-shadow(0 18px 28px rgba(220,112,151,.09));
        animation: kbSceneEntrance 1s .30s cubic-bezier(.18,.82,.2,1) both;
        transform: translate3d(calc(var(--kb-mouse-x) * .20), calc(var(--kb-mouse-y) * .20), 0);
        transition: transform .18s ease-out;
    }

    .kb-scene svg { overflow: visible; }

    .kb-scene svg > g:nth-of-type(1) { animation: kbRainbowGlow 5.4s ease-in-out infinite; }
    .kb-scene svg > g:nth-of-type(2) { animation: kbDecorTwinkle 3.7s ease-in-out infinite; }
    .kb-scene svg > g:nth-of-type(3) { animation: kbSvgCloudBob 5.8s ease-in-out infinite; }
    .kb-scene svg > g:nth-of-type(4) { animation: kbSvgBagBob 4.8s ease-in-out -.7s infinite; }
    .kb-scene svg > g:nth-of-type(5) { animation: kbSvgGiftBob 4.4s ease-in-out -1.4s infinite; }
    .kb-scene svg > g:nth-of-type(6) { animation: kbSvgBunnyBob 4.2s ease-in-out -.5s infinite; }
    .kb-scene svg > g:nth-of-type(7) { animation: kbSvgBearBob 4.9s ease-in-out -1.7s infinite; }
    .kb-scene svg > g:nth-of-type(8) { animation: kbSvgBabyBob 3.9s ease-in-out -.9s infinite; }

    .kb-trust-strip {
        position: relative;
        z-index: 5;
        margin-top: -2px;
        padding: 15px 8px 14px;
        border-radius: 22px;
        border: 1px solid rgba(238,165,190,.76);
        outline: 1px dashed rgba(244,174,198,.55);
        outline-offset: -7px;
        background:
            radial-gradient(circle at 10% 20%, rgba(255,255,255,.92) 0 2px, transparent 3px),
            linear-gradient(180deg, rgba(255,255,255,.91), rgba(255,244,249,.86));
        backdrop-filter: blur(6px);
        box-shadow: 0 14px 30px rgba(226,116,157,.11), inset 0 1px 0 rgba(255,255,255,.9);
        animation: kbTrustEntrance .9s .68s both;
    }

    .kb-trust-item {
        position: relative;
        min-width: 0;
        transition: transform .25s ease, filter .25s ease;
    }

    .kb-trust-item:nth-child(1) { animation: kbTrustItem .6s .78s both; }
    .kb-trust-item:nth-child(2) { animation: kbTrustItem .6s .88s both; }
    .kb-trust-item:nth-child(3) { animation: kbTrustItem .6s .98s both; }
    .kb-trust-item:nth-child(4) { animation: kbTrustItem .6s 1.08s both; }

    .kb-trust-item + .kb-trust-item::before {
        content: "";
        position: absolute;
        left: -4px;
        top: 13%;
        width: 1px;
        height: 74%;
        background: linear-gradient(180deg, transparent, rgba(241,185,204,.66), transparent);
    }

    .kb-trust-item:hover {
        transform: translateY(-5px);
        filter: drop-shadow(0 8px 10px rgba(237,82,135,.10));
    }

    .kb-trust-icon { animation: kbTrustIconFloat 4.1s ease-in-out infinite; }
    .kb-trust-item:nth-child(2) .kb-trust-icon { animation-delay: -.9s; }
    .kb-trust-item:nth-child(3) .kb-trust-icon { animation-delay: -1.8s; }
    .kb-trust-item:nth-child(4) .kb-trust-icon { animation-delay: -2.7s; }

    .kb-form-panel {
        position: relative;
        z-index: 4;
        margin-top: 69px;
        padding: 10px;
        border-radius: 38px;
        border: 1px solid rgba(244,197,213,.74);
        background: rgba(255,255,255,.52);
        backdrop-filter: blur(13px);
        box-shadow: 0 22px 65px rgba(211,99,141,.14), inset 0 1px 0 rgba(255,255,255,.94);
        animation: kbPanelEntrance .95s .12s cubic-bezier(.18,.82,.2,1) both;
        transform: translate3d(calc(var(--kb-mouse-x) * -.08), calc(var(--kb-mouse-y) * -.05), 0);
        transition: transform .20s ease-out;
    }

    .kb-form-panel::before {
        content: "";
        position: absolute;
        inset: 14px;
        border-radius: 31px;
        pointer-events: none;
        background: linear-gradient(115deg, transparent 28%, rgba(255,255,255,.62) 48%, transparent 66%);
        transform: translateX(-125%);
        animation: kbPanelSheen 8s 2.4s ease-in-out infinite;
        z-index: 2;
        mix-blend-mode: screen;
    }

    .kb-form-card {
        min-height: 770px;
        padding: 63px 38px 34px;
        border-radius: 31px;
        border: 1px solid rgba(245,207,221,.93);
        background: radial-gradient(circle at 50% 6%, rgba(255,245,249,.82), transparent 16%), #fff;
        box-shadow: 0 3px 0 rgba(255,255,255,.88) inset, 0 0 0 6px rgba(255,255,255,.30) inset;
        overflow: visible;
    }

    .kb-card-medallion {
        top: -40px;
        gap: 10px;
        animation: kbMedallionFloat 4.3s ease-in-out infinite;
    }

    .kb-medallion-circle {
        width: 87px;
        height: 87px;
        background:
            radial-gradient(circle at 38% 26%, #fff 0 3px, transparent 4px),
            linear-gradient(180deg, #ffe1ec 0%, #fff1f6 100%);
        border: 1.5px solid #efabc1;
        outline: 1px dashed rgba(239,155,184,.7);
        outline-offset: -7px;
        box-shadow: 0 12px 25px rgba(235,82,135,.18), inset 0 0 19px rgba(245,143,176,.12);
    }

    .kb-medallion-bow {
        animation: kbBowWiggle 3.2s ease-in-out infinite;
        filter: drop-shadow(0 5px 7px rgba(237,82,135,.18));
    }

    .kb-medallion-heart {
        animation: kbHeartBeat 2.2s ease-in-out infinite;
        filter: drop-shadow(0 4px 6px rgba(237,82,135,.18));
    }

    .kb-medallion-sparkle { animation: kbTwinkle 2.6s ease-in-out infinite; }
    .kb-card-medallion .kb-medallion-sparkle:last-child { animation-delay: -1.3s; }

    .kb-form-header {
        padding-top: 9px;
        margin-bottom: 25px;
    }

    .kb-form-title {
        font-size: clamp(35px, 3.5vw, 45px);
        line-height: 1.04;
        animation: kbFadeUp .72s .52s both;
    }

    .kb-title-sep {
        max-width: 315px;
        margin: 17px auto 15px;
        animation: kbFadeUp .72s .61s both;
    }

    .kb-title-sep .heart-icon {
        display: inline-block;
        animation: kbHeartBeat 2.1s 1.2s ease-in-out infinite;
    }

    .kb-form-desc {
        font-size: 15px;
        line-height: 1.52;
        color: #60444e;
        animation: kbFadeUp .72s .70s both;
    }

    .kb-form-grid { gap: 14px 15px; }

    .kb-form-grid .kb-field { position: relative; }
    .kb-form-grid .kb-field:nth-child(1) { animation: kbFieldEntrance .58s .76s both; }
    .kb-form-grid .kb-field:nth-child(2) { animation: kbFieldEntrance .58s .84s both; }
    .kb-form-grid .kb-field:nth-child(3) { animation: kbFieldEntrance .58s .92s both; }
    .kb-form-grid .kb-field:nth-child(4) { animation: kbFieldEntrance .58s 1.00s both; }
    .kb-form-grid .kb-field:nth-child(5) { animation: kbFieldEntrance .58s 1.08s both; }

    .kb-label { font-size: 14px; margin-bottom: 8px; }

    .kb-input {
        height: 57px;
        border-radius: 13px;
        border: 1px solid #ecd4dd;
        background: linear-gradient(180deg, rgba(255,255,255,.99), rgba(255,253,254,.99));
        box-shadow: 0 7px 15px rgba(118,56,78,.035), inset 0 1px 0 rgba(255,255,255,.96);
        transition: border-color .25s ease, box-shadow .25s ease, transform .25s ease, background .25s ease;
    }

    .kb-input:hover {
        border-color: #eeb6c9;
        box-shadow: 0 9px 20px rgba(229,116,157,.07), inset 0 1px 0 #fff;
    }

    .kb-input:focus {
        transform: translateY(-1px);
        border-color: #ee7fa7;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(245,143,176,.12), 0 10px 24px rgba(232,102,149,.09);
    }

    .kb-input-icon { transition: color .25s ease, transform .25s ease; }

    .kb-input-wrap:focus-within .kb-input-icon {
        color: #ed6e98;
        transform: translateY(-50%) scale(1.08);
    }

    .kb-password-toggle { transition: color .22s ease, transform .22s ease; }

    .kb-password-toggle:hover {
        transform: translateY(-50%) scale(1.12);
    }

    .kb-safety-banner {
        margin: 9px 0 19px;
        border-radius: 14px;
        background:
            radial-gradient(circle at 96% 50%, rgba(255,255,255,.78) 0 2px, transparent 3px),
            linear-gradient(105deg, #fff7fa, #ffeef4);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.86);
        animation: kbFieldEntrance .62s 1.15s both, kbSafetyGlow 5s 1.9s ease-in-out infinite;
    }

    .kb-safety-icon { animation: kbShieldFloat 4s ease-in-out infinite; }
    .kb-safety-sparkle { animation: kbTwinkle 2.3s ease-in-out infinite; }

    .kb-btn-register {
        position: relative;
        overflow: hidden;
        height: 63px;
        border: 1px solid rgba(255,255,255,.62);
        background:
            linear-gradient(180deg, rgba(255,255,255,.13), transparent 40%),
            linear-gradient(105deg, #f883ad 0%, #ef558a 48%, #ed3f7c 100%);
        box-shadow: 0 14px 28px rgba(235,82,135,.28), inset 0 1px 0 rgba(255,255,255,.65);
        animation: kbFieldEntrance .65s 1.24s both, kbButtonPulse 4.6s 2.1s ease-in-out infinite;
    }

    .kb-btn-register::before {
        content: "";
        position: absolute;
        top: -65%;
        left: -30%;
        width: 22%;
        height: 230%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.72), transparent);
        transform: rotate(19deg);
        animation: kbButtonShine 4.6s 1.7s ease-in-out infinite;
    }

    .kb-btn-register::after {
        content: "✦";
        position: absolute;
        right: 31px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        color: rgba(255,255,255,.95);
        animation: kbTwinkle 2s ease-in-out infinite;
    }

    .kb-btn-register:hover {
        transform: translateY(-4px) scale(1.008);
        filter: saturate(1.05);
        box-shadow: 0 19px 38px rgba(235,82,135,.34), inset 0 1px 0 rgba(255,255,255,.70);
    }

    .kb-register-sparkles { animation: kbTwinkle 2.2s ease-in-out infinite; }

    .kb-bottom-divider {
        margin-top: 20px;
        animation: kbFadeUp .6s 1.34s both;
    }

    .kb-bottom-divider .bow-icon {
        animation: kbBowBounce 3.8s 1.7s ease-in-out infinite;
    }

    .kb-signin-prompt { animation: kbFadeUp .6s 1.42s both; }

    .kb-signin-link {
        position: relative;
    }

    .kb-signin-link::after {
        content: "";
        position: absolute;
        left: 0;
        right: 24px;
        bottom: -2px;
        height: 2px;
        border-radius: 2px;
        background: linear-gradient(90deg, #ed5287, #f8a0bd);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .25s ease;
    }

    .kb-signin-link:hover::after { transform: scaleX(1); }

    .kb-circle-arrow { transition: transform .25s ease; }
    .kb-signin-link:hover .kb-circle-arrow { transform: translateX(3px); }

    .kb-page-footer {
        position: relative;
        z-index: 4;
        margin-top: 34px;
        animation: kbFadeUp .8s 1.4s both;
    }

    .kb-cloud-trim {
        opacity: .78;
        animation: kbFooterCloud 9s ease-in-out infinite;
    }

    .kb-footer-icons span:nth-child(1) { animation: kbTinyFloat 3.7s ease-in-out infinite; }
    .kb-footer-icons span:nth-child(2) { animation: kbTinyFloat 3.7s -.9s ease-in-out infinite; }
    .kb-footer-icons span:nth-child(3) { animation: kbTinyFloat 3.7s -1.8s ease-in-out infinite; }

    .kb-copyright { color: #755761; }

    .kb-floating-symbol {
        z-index: 2;
        text-shadow: 0 5px 8px rgba(244,109,157,.10);
        filter: drop-shadow(0 4px 8px rgba(245,143,176,.08));
    }

    .kb-floating-symbol.s1 { top: 82px; left: 4%; }
    .kb-floating-symbol.s2 { top: 215px; left: 1.5%; }
    .kb-floating-symbol.s3 { top: 325px; left: 4%; }
    .kb-floating-symbol.s4 { top: 555px; left: 2.5%; }
    .kb-floating-symbol.s5 { top: 120px; right: 3%; }
    .kb-floating-symbol.s6 { top: 318px; right: 2%; }
    .kb-floating-symbol.s7 { top: 550px; right: 4%; }
    .kb-floating-symbol.s8 { bottom: 150px; right: 6%; }

    .kb-form-card.kb-field-active::after {
        content: "✦";
        position: absolute;
        right: 22px;
        top: 24px;
        color: #f58fb0;
        font-size: 17px;
        pointer-events: none;
        animation: kbFocusSpark .72s ease-out both;
    }

    @keyframes kbStarField {
        from { background-position: 7px 18px, 37px 42px; }
        to   { background-position: 68px 79px, -60px 139px; }
    }

    @keyframes kbAura {
        0%,100% { opacity: .58; scale: 1; }
        50%     { opacity: .85; scale: 1.08; }
    }

    @keyframes kbCloudA {
        0%,100% { transform: translate3d(0,0,0); }
        50%     { transform: translate3d(18px,-8px,0); }
    }

    @keyframes kbCloudB {
        0%,100% { transform: translate3d(0,0,0); }
        50%     { transform: translate3d(-22px,10px,0); }
    }

    @keyframes kbCloudC {
        0%,100% { transform: translate3d(0,0,0); }
        50%     { transform: translate3d(12px,7px,0); }
    }

    @keyframes kbCloudBank {
        0%,100% { transform: translateX(0); }
        50%     { transform: translateX(18px); }
    }

    @keyframes kbTwinkle {
        0%,100% { opacity: .32; transform: scale(.72) rotate(0); }
        45%     { opacity: 1; transform: scale(1.18) rotate(16deg); }
        62%     { opacity: .66; transform: scale(.93) rotate(-5deg); }
    }

    @keyframes kbHeartDrift {
        0%,100% { transform: translate3d(0,0,0) rotate(-5deg); opacity: .52; }
        50%     { transform: translate3d(5px,-12px,0) rotate(6deg); opacity: .92; }
    }

    @keyframes kbLogoEntrance {
        from { opacity: 0; transform: translateY(-18px) scale(.92); }
        to   { opacity: 1; transform: none; }
    }

    @keyframes kbLogoFloat {
        0%,100% { translate: 0 0; rotate: 0deg; }
        50%     { translate: 0 -5px; rotate: -.5deg; }
    }

    @keyframes kbTitleEntrance {
        from { opacity: 0; transform: translateX(-30px) scale(.96); }
        to   { opacity: 1; transform: none; }
    }

    @keyframes kbPinkWordGlow {
        0%,100% { filter: drop-shadow(0 5px 8px rgba(236,80,131,.10)); }
        50%     { filter: drop-shadow(0 8px 14px rgba(236,80,131,.22)); }
    }

    @keyframes kbFadeUp {
        from { opacity: 0; transform: translateY(15px); }
        to   { opacity: 1; transform: none; }
    }

    @keyframes kbBowBounce {
        0%,100% { transform: translateY(0) rotate(0); }
        45%     { transform: translateY(-4px) rotate(-4deg); }
        62%     { transform: translateY(-1px) rotate(3deg); }
    }

    @keyframes kbSceneEntrance {
        from { opacity: 0; transform: translateY(26px) scale(.93); }
        to   { opacity: 1; transform: none; }
    }

    @keyframes kbRainbowGlow {
        0%,100% { opacity: .78; filter: saturate(.96) drop-shadow(0 0 0 rgba(255,170,202,0)); }
        50%     { opacity: .94; filter: saturate(1.06) drop-shadow(0 0 11px rgba(255,170,202,.18)); }
    }

    @keyframes kbDecorTwinkle {
        0%,100% { opacity: .72; }
        50%     { opacity: 1; }
    }

    @keyframes kbSvgCloudBob {
        0%,100% { translate: 0 0; }
        50%     { translate: 0 -5px; }
    }

    @keyframes kbSvgBagBob {
        0%,100% { translate: 0 0; rotate: 0deg; }
        50%     { translate: 0 -4px; rotate: -.5deg; }
    }

    @keyframes kbSvgGiftBob {
        0%,100% { translate: 0 0; rotate: 0deg; }
        50%     { translate: 0 -5px; rotate: 1deg; }
    }

    @keyframes kbSvgBunnyBob {
        0%,100% { translate: 0 0; }
        50%     { translate: 0 -5px; }
    }

    @keyframes kbSvgBearBob {
        0%,100% { translate: 0 0; rotate: 0deg; }
        50%     { translate: 0 -4px; rotate: .6deg; }
    }

    @keyframes kbSvgBabyBob {
        0%,100% { translate: 0 0; }
        50%     { translate: 0 -7px; }
    }

    @keyframes kbTrustEntrance {
        from { opacity: 0; transform: translateY(18px) scale(.97); }
        to   { opacity: 1; transform: none; }
    }

    @keyframes kbTrustItem {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: none; }
    }

    @keyframes kbTrustIconFloat {
        0%,100% { translate: 0 0; }
        50%     { translate: 0 -4px; }
    }

    @keyframes kbPanelEntrance {
        from { opacity: 0; transform: translateX(34px) scale(.975); }
        to   { opacity: 1; transform: none; }
    }

    @keyframes kbPanelSheen {
        0%,72%,100% { transform: translateX(-125%); opacity: 0; }
        81% { opacity: .52; }
        91% { transform: translateX(125%); opacity: 0; }
    }

    @keyframes kbMedallionFloat {
        0%,100% { translate: 0 0; }
        50%     { translate: 0 -6px; }
    }

    @keyframes kbBowWiggle {
        0%,100% { transform: translateX(-50%) rotate(0); }
        45%     { transform: translateX(-50%) rotate(-5deg); }
        60%     { transform: translateX(-50%) rotate(4deg); }
    }

    @keyframes kbHeartBeat {
        0%,100% { transform: scale(1); }
        38%     { transform: scale(1.13); }
        55%     { transform: scale(.98); }
        67%     { transform: scale(1.07); }
    }

    @keyframes kbFieldEntrance {
        from { opacity: 0; transform: translateY(13px); }
        to   { opacity: 1; transform: none; }
    }

    @keyframes kbSafetyGlow {
        0%,100% { box-shadow: inset 0 1px 0 rgba(255,255,255,.86), 0 0 0 rgba(245,143,176,0); }
        50%     { box-shadow: inset 0 1px 0 rgba(255,255,255,.86), 0 8px 22px rgba(245,143,176,.07); }
    }

    @keyframes kbShieldFloat {
        0%,100% { translate: 0 0; }
        50%     { translate: 0 -3px; }
    }

    @keyframes kbButtonPulse {
        0%,100% { box-shadow: 0 14px 28px rgba(235,82,135,.28), inset 0 1px 0 rgba(255,255,255,.65); }
        50%     { box-shadow: 0 18px 35px rgba(235,82,135,.37), 0 0 0 4px rgba(245,143,176,.055), inset 0 1px 0 rgba(255,255,255,.72); }
    }

    @keyframes kbButtonShine {
        0%,55% { left: -30%; opacity: 0; }
        64%    { opacity: .8; }
        76%    { left: 112%; opacity: 0; }
        100%   { left: 112%; opacity: 0; }
    }

    @keyframes kbFooterCloud {
        0%,100% { transform: translateX(0); }
        50%     { transform: translateX(10px); }
    }

    @keyframes kbTinyFloat {
        0%,100% { transform: translateY(0) rotate(0); }
        50%     { transform: translateY(-4px) rotate(3deg); }
    }

    @keyframes kbFocusSpark {
        0% { opacity: 0; transform: translateY(5px) scale(.55) rotate(-12deg); }
        40% { opacity: 1; transform: translateY(0) scale(1.18) rotate(8deg); }
        100% { opacity: 0; transform: translateY(-7px) scale(.82) rotate(18deg); }
    }

    @media (min-width: 1081px) {
        .kb-left-panel { padding-top: 7px; }
        .kb-form-panel { min-height: 790px; }
        .kb-form-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    }

    @media (max-width: 1080px) {
        .kb-register-page { padding: 24px 18px 48px; }

        .kb-register-shell {
            max-width: 680px;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .kb-logo-wrap {
            margin-left: 0;
            display: flex;
            justify-content: center;
        }

        .kb-left-panel { padding-bottom: 0; }

        .kb-form-panel {
            margin-top: 16px;
        }

        .kb-form-card {
            min-height: auto;
        }

        .kb-cloud-1 { left: 8%; }
        .kb-cloud-3 { right: 4%; }
        .kb-cloud-7 { display: none; }
    }

    @media (max-width: 640px) {
        .kb-register-page {
            padding: 14px 9px 34px;
            background:
                radial-gradient(circle at 50% 5%, rgba(255,255,255,.55), transparent 24%),
                linear-gradient(180deg, #fff0f5 0%, #fff7fa 44%, #ffedf4 100%);
        }

        .kb-logo-wrap img { width: 150px; }
        .kb-logo-wrap { margin-bottom: 17px; }

        .kb-hero-title {
            font-size: 43px;
            line-height: .98;
        }

        .kb-left-copy p { font-size: 14.5px; }

        .kb-scene {
            max-width: 430px;
            margin-top: 10px;
        }

        .kb-trust-strip {
            gap: 8px;
            padding: 13px 8px;
        }

        .kb-trust-item + .kb-trust-item::before { display: none; }

        .kb-form-panel {
            margin-top: 24px;
            border-radius: 30px;
            padding: 7px;
        }

        .kb-form-card {
            min-height: 0;
            padding: 54px 18px 27px;
            border-radius: 25px;
        }

        .kb-card-medallion { top: -36px; }

        .kb-medallion-circle {
            width: 76px;
            height: 76px;
        }

        .kb-form-title { font-size: 32px; }
        .kb-form-desc { font-size: 14px; }
        .kb-form-grid { grid-template-columns: 1fr; }
        .kb-input { height: 55px; }

        .kb-safety-banner { padding: 12px 13px; }
        .kb-safety-text span { font-size: 11.5px; }

        .kb-btn-register {
            height: 58px;
            font-size: 18px;
        }

        .kb-sky-cloud { opacity: .35; }
        .kb-cloud-1 { top: 32px; left: 52%; width: 115px; }
        .kb-cloud-2 { top: 88px; right: -45px; width: 130px; }
        .kb-cloud-3,
        .kb-cloud-5,
        .kb-cloud-6,
        .kb-cloud-7 { display: none; }

        .kb-bottom-cloud-bank { opacity: .38; }

        .kb-floating-symbol.s4,
        .kb-floating-symbol.s7 { display: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        .kb-register-page *,
        .kb-register-page *::before,
        .kb-register-page *::after {
            animation-duration: .001ms !important;
            animation-iteration-count: 1 !important;
            scroll-behavior: auto !important;
        }

        .kb-scene,
        .kb-form-panel {
            transform: none !important;
        }
    }

</style>
@endpush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.signup-form.page-title')
    </x-slot>

    <div class="kb-register-page">
        {{-- DREAMLAND BACKGROUND — decorative only --}}
        <div class="kb-dream-sky" aria-hidden="true">
            <span class="kb-sky-cloud kb-cloud-1"></span>
            <span class="kb-sky-cloud kb-cloud-2"></span>
            <span class="kb-sky-cloud kb-cloud-3"></span>
            <span class="kb-sky-cloud kb-cloud-4"></span>
            <span class="kb-sky-cloud kb-cloud-5"></span>
            <span class="kb-sky-cloud kb-cloud-6"></span>
            <span class="kb-sky-cloud kb-cloud-7"></span>

            <span class="kb-sky-sparkle kb-star-1">✦</span>
            <span class="kb-sky-sparkle kb-star-2">✧</span>
            <span class="kb-sky-sparkle kb-star-3">✦</span>
            <span class="kb-sky-sparkle kb-star-4">✧</span>
            <span class="kb-sky-sparkle kb-star-5">✦</span>
            <span class="kb-sky-sparkle kb-star-6">✧</span>

            <span class="kb-sky-heart kb-heart-1">♥</span>
            <span class="kb-sky-heart kb-heart-2">♡</span>
            <span class="kb-sky-heart kb-heart-3">♥</span>
            <span class="kb-sky-heart kb-heart-4">♡</span>

            <div class="kb-bottom-cloud-bank kb-bank-back">
                <span></span><span></span><span></span><span></span><span></span><span></span>
            </div>

            <div class="kb-bottom-cloud-bank kb-bank-front">
                <span></span><span></span><span></span><span></span><span></span><span></span><span></span>
            </div>
        </div>

        <!-- Ambient floating kawaii symbols -->
        <span class="kb-floating-symbol s1">♡</span>
        <span class="kb-floating-symbol s2">♥</span>
        <span class="kb-floating-symbol s3">✦</span>
        <span class="kb-floating-symbol s4">♥</span>
        <span class="kb-floating-symbol s5">♥</span>
        <span class="kb-floating-symbol s6">✧</span>
        <span class="kb-floating-symbol s7">✦</span>
        <span class="kb-floating-symbol s8">♡</span>

        <div class="kb-register-shell">
            {{-- LEFT COLUMN --}}
            <section class="kb-left-panel">
                {!! view_render_event('bagisto.shop.customers.sign-up.logo.before') !!}

                <div class="kb-logo-wrap">
                    <a href="{{ route('shop.home.index') }}" aria-label="{{ core()->getCurrentChannel()->name ?? 'Kawaii Blessings' }}">
                        <img
                            src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                            alt="{{ core()->getCurrentChannel()->logo_alt ?: config('app.name') }}"
                        >
                    </a>
                </div>

                {!! view_render_event('bagisto.shop.customers.sign-up.logo.after') !!}

                <div class="kb-left-copy">
                    <h1 class="kb-hero-title">
                        Join the<br>
                        <span class="pink">Kawaii</span><br>
                        Family!
                    </h1>

                    <div class="kb-ribbon-divider" aria-hidden="true">
                        <span class="kb-dash-line"></span>
                        <span class="kb-bow-icon">
                            <svg width="38" height="24" viewBox="0 0 38 24" fill="none">
                                <path d="M19 12 C10 0 4 20 19 12 Z" fill="#fca4c0" stroke="#eb6793" stroke-width="1.5"/>
                                <path d="M19 12 C28 0 34 20 19 12 Z" fill="#fca4c0" stroke="#eb6793" stroke-width="1.5"/>
                                <circle cx="19" cy="12" r="5" fill="#f25f8f" stroke="#eb6793" stroke-width="1.2"/>
                                <path d="M16 15 Q11 22 8 23" stroke="#fca4c0" stroke-width="3" stroke-linecap="round"/>
                                <path d="M22 15 Q27 22 30 23" stroke="#fca4c0" stroke-width="3" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span class="kb-dash-line"></span>
                    </div>

                    <p>
                        Create your account and step into a<br>
                        world full of adorable treasures,<br>
                        sparkly deals and kawaii joy! ✨
                    </p>
                </div>

                {{-- CENTER ILLUSTRATION SCENE (1:1 VECTOR REPLICA) --}}
                <div class="kb-scene" aria-hidden="true">
                    <svg viewBox="0 0 460 360" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <!-- Cloud Gradient -->
                            <linearGradient id="cloud-grad" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#ffffff"/>
                                <stop offset="85%" stop-color="#fffafd"/>
                                <stop offset="100%" stop-color="#ffeef4"/>
                            </linearGradient>

                            <!-- Shopping Bag Gradient -->
                            <linearGradient id="bag-grad" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#ffd5e3"/>
                                <stop offset="100%" stop-color="#f8adc4"/>
                            </linearGradient>

                            <!-- Gift Box Gradient -->
                            <linearGradient id="gift-box-grad" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#fde08f"/>
                                <stop offset="100%" stop-color="#f5ba58"/>
                            </linearGradient>

                            <!-- Puffy Heart Gradient -->
                            <linearGradient id="heart-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#ff8cb0"/>
                                <stop offset="100%" stop-color="#eb5185"/>
                            </linearGradient>

                            <!-- Bear Fur Gradient -->
                            <linearGradient id="bear-fur-grad" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#f5cf9e"/>
                                <stop offset="100%" stop-color="#e2aa6c"/>
                            </linearGradient>

                            <!-- Filters -->
                            <filter id="soft-shadow" x="-10%" y="-10%" width="130%" height="130%">
                                <feDropShadow dx="0" dy="8" stdDeviation="10" flood-color="#f29bb7" flood-opacity="0.16"/>
                            </filter>
                            <filter id="heart-shadow" x="-20%" y="-20%" width="140%" height="140%">
                                <feDropShadow dx="0" dy="6" stdDeviation="6" flood-color="#eb5185" flood-opacity="0.25"/>
                            </filter>
                        </defs>

                        <!-- RAINBOW -->
                        <g opacity="0.82">
                            <path d="M 45 295 A 185 185 0 0 1 415 295" fill="none" stroke="#ffbccc" stroke-width="14" stroke-linecap="round"/>
                            <path d="M 59 295 A 171 171 0 0 1 401 295" fill="none" stroke="#fed8ad" stroke-width="14" stroke-linecap="round"/>
                            <path d="M 73 295 A 157 157 0 0 1 387 295" fill="none" stroke="#fff1b3" stroke-width="14" stroke-linecap="round"/>
                            <path d="M 87 295 A 143 143 0 0 1 373 295" fill="none" stroke="#d6cbf5" stroke-width="14" stroke-linecap="round"/>
                            <path d="M 101 295 A 129 129 0 0 1 359 295" fill="none" stroke="#ffcbe0" stroke-width="14" stroke-linecap="round"/>
                        </g>

                        <!-- FLOATING BACKGROUND HEARTS & SPARKLES -->
                        <g>
                            <!-- Pink Hearts -->
                            <path d="M 28 95 C 24 90 18 90 18 96 C 18 102 28 108 28 108 C 28 108 38 102 38 96 C 38 90 32 90 28 95 Z" fill="#ff7da2" opacity="0.85"/>
                            <path d="M 405 105 C 402 101 397 101 397 106 C 397 111 405 116 405 116 C 405 116 413 111 413 106 C 413 101 408 101 405 105 Z" fill="#ff7da2" opacity="0.85"/>
                            <path d="M 398 200 C 396 197 392 197 392 201 C 392 205 398 209 398 209 C 398 209 404 205 404 201 C 404 197 400 197 398 200 Z" fill="#ff7da2" opacity="0.8"/>
                            <path d="M 54 195 C 52 192 48 192 48 196 C 48 200 54 204 54 204 C 54 204 60 200 60 196 C 60 192 56 192 54 195 Z" fill="#ff7da2" opacity="0.8"/>

                            <!-- Sparkle Stars -->
                            <path d="M 382 55 Q 382 66 393 66 Q 382 66 382 77 Q 382 66 371 66 Q 382 66 382 55 Z" fill="#ffe28a"/>
                            <path d="M 68 135 Q 68 143 76 143 Q 68 143 68 151 Q 68 143 60 143 Q 68 143 68 135 Z" fill="#ffe28a"/>
                            <path d="M 364 140 Q 364 147 371 147 Q 364 147 364 154 Q 364 147 357 147 Q 364 147 364 140 Z" fill="#ff99bc"/>
                        </g>

                        <!-- BASE CLOUDS -->
                        <g filter="url(#soft-shadow)">
                            <path d="M 25 330 C 25 285 75 280 100 300 C 135 270 195 270 225 300 C 265 265 330 270 360 305 C 395 280 445 295 445 340 L 25 340 Z" fill="url(#cloud-grad)" stroke="#fcdde7" stroke-width="1.8"/>
                        </g>

                        <!-- SHOPPING BAG -->
                        <g transform="translate(68, 218) rotate(-4)">
                            <!-- Bag Handles -->
                            <path d="M 22 14 C 22 -8 58 -8 58 14" fill="none" stroke="#cba076" stroke-width="4" stroke-linecap="round"/>
                            <path d="M 26 14 C 26 -4 54 -4 54 14" fill="none" stroke="#e8c7a2" stroke-width="2" stroke-linecap="round"/>
                            <!-- Bag Body -->
                            <rect x="0" y="14" width="80" height="88" rx="12" fill="url(#bag-grad)" stroke="#e894af" stroke-width="2.2"/>
                            <!-- Bag Text -->
                            <text x="40" y="54" text-anchor="middle" font-family="'Fredoka', 'Arial Rounded MT Bold', sans-serif" font-weight="700" font-size="14" fill="#e84c7a" letter-spacing="-0.4">kawaii</text>
                            <text x="40" y="69" text-anchor="middle" font-family="'Fredoka', 'Arial Rounded MT Bold', sans-serif" font-weight="600" font-size="10" fill="#d9547d">blessings</text>
                        </g>

                        <!-- GOLDEN GIFT BOX & STAR -->
                        <g transform="translate(24, 258)">
                            <rect x="4" y="16" width="44" height="40" rx="8" fill="url(#gift-box-grad)" stroke="#d49a42" stroke-width="2"/>
                            <rect x="0" y="10" width="52" height="12" rx="5" fill="#fddb82" stroke="#d49a42" stroke-width="2"/>
                            <!-- Pink Ribbon -->
                            <rect x="21" y="10" width="10" height="46" fill="#f76d95"/>
                            <rect x="4" y="27" width="44" height="8" fill="#f76d95"/>
                            <!-- Bow -->
                            <path d="M 26 10 C 17 2 13 8 23 10 Z" fill="#ff85aa" stroke="#de567c" stroke-width="1.5"/>
                            <path d="M 26 10 C 35 2 39 8 29 10 Z" fill="#ff85aa" stroke="#de567c" stroke-width="1.5"/>
                            <circle cx="26" cy="10" r="3.5" fill="#e84271"/>

                            <!-- Cute Smiling Star -->
                            <g transform="translate(40, 26) scale(0.85)">
                                <polygon points="18,0 23,12 36,13 26,22 29,35 18,28 7,35 10,22 0,13 13,12" fill="#ffe779" stroke="#dfb632" stroke-width="2" stroke-linejoin="round"/>
                                <circle cx="13" cy="16" r="1.6" fill="#4a3138"/>
                                <circle cx="23" cy="16" r="1.6" fill="#4a3138"/>
                                <path d="M 16 20 Q 18 23 20 20" fill="none" stroke="#4a3138" stroke-width="1.5" stroke-linecap="round"/>
                                <circle cx="10" cy="18" r="2.2" fill="#ff99b8" opacity="0.75"/>
                                <circle cx="26" cy="18" r="2.2" fill="#ff99b8" opacity="0.75"/>
                            </g>
                        </g>

                        <!-- MAIN BUNNY (CENTER) -->
                        <g transform="translate(142, 122)">
                            <!-- Bunny Body -->
                            <ellipse cx="90" cy="188" rx="55" ry="46" fill="#ffffff" stroke="#dcb5c2" stroke-width="3"/>

                            <!-- Left Ear with Bow (Viewer's Left) -->
                            <g transform="rotate(-10 60 55)">
                                <rect x="42" y="-30" width="34" height="85" rx="17" fill="#ffffff" stroke="#dcb5c2" stroke-width="3"/>
                                <rect x="48" y="-20" width="22" height="66" rx="11" fill="#ffccd9"/>
                            </g>
                            <!-- Big Pink Bow on Left Ear -->
                            <g transform="translate(56, 26) rotate(-14)">
                                <path d="M 0 0 C -22 -16 -24 14 0 0 Z" fill="#f785a8" stroke="#db5981" stroke-width="2"/>
                                <path d="M 0 0 C 22 -16 24 14 0 0 Z" fill="#f785a8" stroke="#db5981" stroke-width="2"/>
                                <ellipse cx="0" cy="0" rx="6" ry="6" fill="#ee5283" stroke="#db5981" stroke-width="1.5"/>
                                <path d="M -4 4 Q -12 20 -16 26" fill="none" stroke="#f785a8" stroke-width="4" stroke-linecap="round"/>
                                <path d="M 4 4 Q 10 20 14 26" fill="none" stroke="#f785a8" stroke-width="4" stroke-linecap="round"/>
                            </g>
                            <!-- Right Ear (Upright) -->
                            <g transform="rotate(10 120 55)">
                                <rect x="104" y="-30" width="34" height="85" rx="17" fill="#ffffff" stroke="#dcb5c2" stroke-width="3"/>
                                <rect x="110" y="-20" width="22" height="66" rx="11" fill="#ffccd9"/>
                            </g>

                            <!-- Bunny Head -->
                            <ellipse cx="90" cy="96" rx="68" ry="58" fill="#ffffff" stroke="#dcb5c2" stroke-width="3"/>

                            <!-- Bunny Face -->
                            <!-- Left Eye: Wink with cute lashes -->
                            <path d="M 56 90 Q 66 80 76 90" fill="none" stroke="#482d35" stroke-width="3.5" stroke-linecap="round"/>
                            <path d="M 74 84 L 80 81" fill="none" stroke="#482d35" stroke-width="2.5" stroke-linecap="round"/>
                            <!-- Right Eye: Shiny Eye -->
                            <ellipse cx="114" cy="86" rx="7" ry="8.5" fill="#482d35"/>
                            <circle cx="112" cy="83" r="2.8" fill="#ffffff"/>
                            <circle cx="117" cy="90" r="1.2" fill="#ffffff"/>
                            <!-- Nose -->
                            <path d="M 86 98 Q 90 96 94 98 Q 90 104 86 98 Z" fill="#f584a3"/>
                            <!-- Mouth -->
                            <path d="M 84 103 Q 90 110 96 103" fill="none" stroke="#482d35" stroke-width="2.5" stroke-linecap="round"/>
                            <!-- Blush Cheeks -->
                            <ellipse cx="54" cy="102" rx="12" ry="7.5" fill="#ff9cb8" opacity="0.7"/>
                            <ellipse cx="126" cy="100" rx="12" ry="7.5" fill="#ff9cb8" opacity="0.7"/>

                            <!-- Puffy 3D Pink Heart -->
                            <g transform="translate(90, 154)">
                                <path d="M 0 28 C -36 2 -48 -24 -24 -36 C -8 -42 0 -24 0 -24 C 0 -24 8 -42 24 -36 C 48 -24 36 2 0 28 Z" fill="url(#heart-grad)" stroke="#de547c" stroke-width="2" filter="url(#heart-shadow)"/>
                                <path d="M -16 -30 C -26 -22 -24 -8 -16 -2" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" opacity="0.75"/>
                            </g>

                            <!-- Bunny Paws -->
                            <ellipse cx="64" cy="146" rx="13" ry="10" fill="#ffffff" stroke="#dcb5c2" stroke-width="2.5" transform="rotate(-15 64 146)"/>
                            <ellipse cx="116" cy="146" rx="13" ry="10" fill="#ffffff" stroke="#dcb5c2" stroke-width="2.5" transform="rotate(15 116 146)"/>
                        </g>

                        <!-- TEDDY BEAR (RIGHT) -->
                        <g transform="translate(290, 172)">
                            <ellipse cx="46" cy="98" rx="34" ry="32" fill="url(#bear-fur-grad)" stroke="#c48f57" stroke-width="2.5"/>
                            <!-- Bear Ears -->
                            <circle cx="18" cy="22" r="14" fill="url(#bear-fur-grad)" stroke="#c48f57" stroke-width="2.5"/>
                            <circle cx="18" cy="22" r="8" fill="#f7b7cb"/>
                            <circle cx="74" cy="22" r="14" fill="url(#bear-fur-grad)" stroke="#c48f57" stroke-width="2.5"/>
                            <circle cx="74" cy="22" r="8" fill="#f7b7cb"/>
                            <!-- Bear Head -->
                            <ellipse cx="46" cy="46" rx="38" ry="34" fill="url(#bear-fur-grad)" stroke="#c48f57" stroke-width="2.5"/>
                            <!-- Bear Eyes -->
                            <circle cx="32" cy="42" r="4.5" fill="#422930"/>
                            <circle cx="31" cy="40" r="1.5" fill="#ffffff"/>
                            <circle cx="60" cy="42" r="4.5" fill="#422930"/>
                            <circle cx="59" cy="40" r="1.5" fill="#ffffff"/>
                            <!-- Bear Snout -->
                            <ellipse cx="46" cy="52" rx="12" ry="9" fill="#fae4ca"/>
                            <ellipse cx="46" cy="48" rx="4" ry="3" fill="#633d45"/>
                            <path d="M 46 51 L 46 56 M 43 56 Q 46 59 49 56" fill="none" stroke="#633d45" stroke-width="1.8" stroke-linecap="round"/>
                            <!-- Bear Blush -->
                            <ellipse cx="23" cy="52" rx="6" ry="4" fill="#ff99b6" opacity="0.6"/>
                            <ellipse cx="69" cy="52" rx="6" ry="4" fill="#ff99b6" opacity="0.6"/>
                            <!-- Bear Bowtie -->
                            <g transform="translate(46, 76)">
                                <path d="M 0 0 L -10 -6 L -10 6 Z" fill="#f77ca0" stroke="#db5177" stroke-width="1.5"/>
                                <path d="M 0 0 L 10 -6 L 10 6 Z" fill="#f77ca0" stroke="#db5177" stroke-width="1.5"/>
                                <circle cx="0" cy="0" r="3.5" fill="#ea4c77"/>
                            </g>
                        </g>

                        <!-- BABY COMPANION -->
                        <g transform="translate(348, 246)">
                            <ellipse cx="20" cy="26" rx="16" ry="18" fill="#fff5ec" stroke="#dcb59c" stroke-width="2"/>
                            <circle cx="10" cy="12" r="6" fill="#fff5ec" stroke="#dcb59c" stroke-width="2"/>
                            <circle cx="10" cy="12" r="3" fill="#ffb8cc"/>
                            <circle cx="30" cy="12" r="6" fill="#fff5ec" stroke="#dcb59c" stroke-width="2"/>
                            <circle cx="30" cy="12" r="3" fill="#ffb8cc"/>
                            <circle cx="15" cy="24" r="2.5" fill="#4a3036"/>
                            <circle cx="25" cy="24" r="2.5" fill="#4a3036"/>
                            <ellipse cx="20" cy="28" rx="2.5" ry="1.8" fill="#e87392"/>
                            <ellipse cx="9" cy="28" rx="3.5" ry="2" fill="#ff99b8" opacity="0.7"/>
                            <ellipse cx="31" cy="28" rx="3.5" ry="2" fill="#ff99b8" opacity="0.7"/>
                            <g transform="translate(20, 8)">
                                <path d="M 0 0 L -6 -4 L -6 4 Z" fill="#f784a5"/>
                                <path d="M 0 0 L 6 -4 L 6 4 Z" fill="#f784a5"/>
                                <circle cx="0" cy="0" r="2" fill="#ee4d7c"/>
                            </g>
                        </g>
                    </svg>
                </div>

                {{-- TRUST BADGES (4-GRID) --}}
                <div class="kb-trust-strip">
                    <div class="kb-trust-item">
                        <div class="kb-trust-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                                <path d="M12 3 L19 6 V11 C19 16 12 21 12 21 C12 21 5 16 5 11 V6 L12 3 Z" fill="#fff2f6" stroke="#f2628e" stroke-width="1.8"/>
                                <path d="M12 14 C12 14 8.5 11.5 8.5 9.5 C8.5 8 9.8 7.2 11 8.2 C11.5 8.6 12 9 12 9 C12 9 12.5 8.6 13 8.2 C14.2 7.2 15.5 8 15.5 9.5 C15.5 11.5 12 14 12 14 Z" fill="#f2628e"/>
                            </svg>
                        </div>
                        <strong class="pink">100% Authentic</strong>
                        <span>Products</span>
                    </div>

                    <div class="kb-trust-item">
                        <div class="kb-trust-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#f2628e" stroke-width="1.8">
                                <rect x="3" y="9" width="18" height="12" rx="3" fill="#fff2f6"/>
                                <rect x="2" y="5" width="20" height="4" rx="2" fill="#fff2f6"/>
                                <line x1="12" y1="5" x2="12" y2="21"/>
                                <path d="M12 5 C10 1 6 3 9 5 Z" fill="#f2628e"/>
                                <path d="M12 5 C14 1 18 3 15 5 Z" fill="#f2628e"/>
                            </svg>
                        </div>
                        <strong>Exclusive</strong>
                        <span>Rewards</span>
                    </div>

                    <div class="kb-trust-item">
                        <div class="kb-trust-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#f2628e" stroke-width="1.8">
                                <rect x="1" y="6" width="13" height="11" rx="2" fill="#fff2f6"/>
                                <path d="M14 9 L18 9 L22 13 L22 17 L14 17 Z" fill="#fff2f6"/>
                                <circle cx="5.5" cy="18.5" r="2.5" fill="#ffffff" stroke="#f2628e" stroke-width="1.8"/>
                                <circle cx="17.5" cy="18.5" r="2.5" fill="#ffffff" stroke="#f2628e" stroke-width="1.8"/>
                                <line x1="1" y1="9" x2="4" y2="9" stroke-linecap="round"/>
                                <line x1="0" y1="12" x2="3" y2="12" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <strong>Fast Shipping</strong>
                        <span>in UAE</span>
                    </div>

                    <div class="kb-trust-item">
                        <div class="kb-trust-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" fill="#fff2f6" stroke="#f2628e" stroke-width="1.8"/>
                                <path d="M12 17 C12 17 7 13.5 7 10.5 C7 8.5 8.5 7.5 10.2 8.5 C11.2 9 12 9.8 12 9.8 C12 9.8 12.8 9 13.8 8.5 C15.5 7.5 17 8.5 17 10.5 C17 13.5 12 17 12 17 Z" fill="#f2628e"/>
                            </svg>
                        </div>
                        <strong>Made with</strong>
                        <span>Love</span>
                    </div>
                </div>
            </section>

            {{-- RIGHT COLUMN - FORM CARD --}}
            <section class="kb-form-panel">
                <div class="kb-form-card">
                    <!-- Top Medallion Badge with Bow & Heart -->
                    <div class="kb-card-medallion" aria-hidden="true">
                        <span class="kb-medallion-sparkle">✧ ✦</span>
                        <div class="kb-medallion-circle">
                            <div class="kb-medallion-bow">
                                <svg width="46" height="26" viewBox="0 0 44 24" fill="none">
                                    <path d="M22 10 C12 -2 6 18 22 10 Z" fill="#fca4c0" stroke="#eb6793" stroke-width="1.5"/>
                                    <path d="M22 10 C32 -2 38 18 22 10 Z" fill="#fca4c0" stroke="#eb6793" stroke-width="1.5"/>
                                    <circle cx="22" cy="10" r="5.5" fill="#f25f8f" stroke="#eb6793" stroke-width="1.5"/>
                                    <path d="M19 14 Q14 22 10 23" stroke="#fca4c0" stroke-width="3" stroke-linecap="round"/>
                                    <path d="M25 14 Q30 22 34 23" stroke="#fca4c0" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="kb-medallion-heart">
                                <svg width="26" height="24" viewBox="0 0 24 24" fill="none">
                                    <defs>
                                        <linearGradient id="medallion-heart-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#ff7ca1"/>
                                            <stop offset="100%" stop-color="#eb5185"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M12 21 C12 21 3 15 3 8.5 C3 5 5.5 3 8.5 3 C10.5 3 12 4.5 12 4.5 C12 4.5 13.5 3 15.5 3 C18.5 3 21 5 21 8.5 C21 15 12 21 12 21 Z" fill="url(#medallion-heart-grad)" stroke="#de4e7b" stroke-width="1.2"/>
                                </svg>
                            </div>
                        </div>
                        <span class="kb-medallion-sparkle">✦ ✧</span>
                    </div>

                    <div class="kb-form-header">
                        <h2 class="kb-form-title">
                            Create your <span class="pink">cute</span><br>
                            customer account
                        </h2>

                        <div class="kb-title-sep" aria-hidden="true">
                            <span class="line"></span>
                            <span class="heart-icon">♥</span>
                            <span class="line"></span>
                        </div>

                        <p class="kb-form-desc">
                            If you are new to our store,<br>
                            we’re so happy to have you here! (˶˃ ᵕ ˂˶)♡
                        </p>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.signup_form_controls.before') !!}

                    <form method="POST" action="{{ route('shop.customers.register.store') }}">
                        @csrf

                        <div class="kb-form-grid">
                            <!-- First Name -->
                            <div class="kb-field">
                                <label class="kb-label" for="first_name">First Name</label>
                                <div class="kb-input-wrap">
                                    <span class="kb-input-icon" aria-hidden="true">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                            <circle cx="12" cy="8" r="4.5"/>
                                            <path d="M4 20 C4 16 7.5 14 12 14 C16.5 14 20 16 20 20"/>
                                        </svg>
                                    </span>
                                    <input
                                        id="first_name"
                                        name="first_name"
                                        type="text"
                                        class="kb-input"
                                        placeholder="Your first name"
                                        value="{{ old('first_name') }}"
                                        required
                                    >
                                </div>
                                @error('first_name') <span class="kb-error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="kb-field">
                                <label class="kb-label" for="last_name">Last Name</label>
                                <div class="kb-input-wrap">
                                    <span class="kb-input-icon" aria-hidden="true">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                            <circle cx="12" cy="8" r="4.5"/>
                                            <path d="M4 20 C4 16 7.5 14 12 14 C16.5 14 20 16 20 20"/>
                                        </svg>
                                    </span>
                                    <input
                                        id="last_name"
                                        name="last_name"
                                        type="text"
                                        class="kb-input"
                                        placeholder="Your last name"
                                        value="{{ old('last_name') }}"
                                        required
                                    >
                                </div>
                                @error('last_name') <span class="kb-error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div class="kb-field full">
                                <label class="kb-label" for="email">Email</label>
                                <div class="kb-input-wrap">
                                    <span class="kb-input-icon" aria-hidden="true">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="5" width="18" height="14" rx="3"/>
                                            <path d="M3 7 L12 13 L21 7"/>
                                        </svg>
                                    </span>
                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        class="kb-input"
                                        placeholder="Your email address"
                                        value="{{ old('email') }}"
                                        required
                                    >
                                </div>
                                @error('email') <span class="kb-error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Password -->
                            <div class="kb-field full">
                                <label class="kb-label" for="password">Password</label>
                                <div class="kb-input-wrap has-toggle">
                                    <span class="kb-input-icon" aria-hidden="true">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                            <rect x="5" y="11" width="14" height="10" rx="3"/>
                                            <path d="M8 11 V7 C8 4.8 9.8 3 12 3 C14.2 3 16 4.8 16 7 V11"/>
                                            <circle cx="12" cy="16" r="1.5" fill="currentColor"/>
                                        </svg>
                                    </span>
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        class="kb-input"
                                        placeholder="Create a password"
                                        required
                                    >
                                    <button class="kb-password-toggle" type="button" data-toggle-password="password" aria-label="Toggle password visibility">
                                        <svg class="kb-eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12 C1 12 5 4 12 4 C19 4 23 12 23 12 C23 12 19 20 12 20 C5 20 1 12 1 12 Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                            <line x1="3" y1="21" x2="21" y2="3"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('password') <span class="kb-error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="kb-field full">
                                <label class="kb-label" for="password_confirmation">Confirm Password</label>
                                <div class="kb-input-wrap has-toggle">
                                    <span class="kb-input-icon" aria-hidden="true">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                            <rect x="5" y="11" width="14" height="10" rx="3"/>
                                            <path d="M8 11 V7 C8 4.8 9.8 3 12 3 C14.2 3 16 4.8 16 7 V11"/>
                                            <circle cx="12" cy="16" r="1.5" fill="currentColor"/>
                                        </svg>
                                    </span>
                                    <input
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        type="password"
                                        class="kb-input"
                                        placeholder="Confirm your password"
                                        required
                                    >
                                    <button class="kb-password-toggle" type="button" data-toggle-password="password_confirmation" aria-label="Toggle password confirmation visibility">
                                        <svg class="kb-eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12 C1 12 5 4 12 4 C19 4 23 12 23 12 C23 12 19 20 12 20 C5 20 1 12 1 12 Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                            <line x1="3" y1="21" x2="21" y2="3"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('password_confirmation') <span class="kb-error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Safety Banner -->
                        <div class="kb-safety-banner">
                            <div class="kb-safety-left">
                                <div class="kb-safety-icon" aria-hidden="true">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 2 L20 5 V11 C20 16.5 12 21.5 12 21.5 C12 21.5 4 16.5 4 11 V5 L12 2 Z" fill="#ffdce6" stroke="#f2628e" stroke-width="1.8"/>
                                        <path d="M12 14 C12 14 8.5 11.5 8.5 9.5 C8.5 8 9.8 7.2 11 8.2 C11.5 8.6 12 9 12 9 C12 9 12.5 8.6 13 8.2 C14.2 7.2 15.5 8 15.5 9.5 C15.5 11.5 12 14 12 14 Z" fill="#f2628e"/>
                                    </svg>
                                </div>
                                <div class="kb-safety-text">
                                    <strong>We keep your information safe</strong>
                                    <span>Your details are protected and will never be shared.</span>
                                </div>
                            </div>
                            <div class="kb-safety-sparkle" aria-hidden="true">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="#f79ab8">
                                    <path d="M12 0 Q12 12 24 12 Q12 12 12 24 Q12 12 0 12 Q12 12 12 0 Z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Captcha Support (if enabled) -->
                        @if (core()->getConfigData('customer.captcha.credentials.status'))
                            <div class="mb-4">
                                {!! \Webkul\Customer\Facades\Captcha::render() !!}
                                @error('recaptcha_token') <span class="kb-error">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <!-- GDPR Agreement (if enabled) -->
                        @if(
                            core()->getConfigData('general.gdpr.settings.enabled')
                            && core()->getConfigData('general.gdpr.agreement.enabled')
                        )
                            <div class="mb-4 flex select-none items-center gap-2">
                                <input
                                    type="checkbox"
                                    name="agreement"
                                    id="agreement"
                                    value="1"
                                    required
                                    class="accent-[#ed5287] w-4 h-4 cursor-pointer"
                                />
                                <label for="agreement" class="cursor-pointer text-sm text-[#70525d] font-semibold">
                                    {{ core()->getConfigData('general.gdpr.agreement.agreement_label') }}
                                </label>
                            </div>
                        @endif

                        <!-- Register Submit Button -->
                        <button type="submit" class="kb-btn-register">
                            <span>Register</span>
                            <svg class="kb-register-sparkles" width="28" height="24" viewBox="0 0 28 24" fill="#ffffff" aria-hidden="true">
                                <path d="M12 0 Q12 8 20 8 Q12 8 12 16 Q12 8 4 8 Q12 8 12 0 Z"/>
                                <path d="M22 14 Q22 18 26 18 Q22 18 22 22 Q22 18 18 18 Q22 18 22 14 Z"/>
                            </svg>
                        </button>

                        <div class="kb-bottom-divider" aria-hidden="true">
                            <span class="line"></span>
                            <span class="bow-icon">
                                <svg width="34" height="20" viewBox="0 0 38 24" fill="none">
                                    <path d="M19 12 C10 0 4 20 19 12 Z" fill="#fca4c0" stroke="#eb6793" stroke-width="1.5"/>
                                    <path d="M19 12 C28 0 34 20 19 12 Z" fill="#fca4c0" stroke="#eb6793" stroke-width="1.5"/>
                                    <circle cx="19" cy="12" r="5" fill="#f25f8f" stroke="#eb6793" stroke-width="1.2"/>
                                    <path d="M16 15 Q11 22 8 23" stroke="#fca4c0" stroke-width="3" stroke-linecap="round"/>
                                    <path d="M22 15 Q27 22 30 23" stroke="#fca4c0" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <span class="line"></span>
                        </div>

                        <div class="kb-signin-prompt">
                            Already have an account ?
                            <a href="{{ route('shop.customer.session.index') }}" class="kb-signin-link">
                                <span>Sign In</span>
                                <span class="kb-circle-arrow">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ed5287" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="10 8 14 12 10 16"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </form>

                    {!! view_render_event('bagisto.shop.customers.signup_form_controls.after') !!}
                </div>
            </section>
        </div>

        {{-- PAGE FOOTER --}}
        <footer class="kb-page-footer">
            <div class="kb-cloud-trim" aria-hidden="true">
                <svg viewBox="0 0 1000 36" fill="none" preserveAspectRatio="none">
                    <path d="M 0 36 C 40 10 80 10 120 36 C 160 10 200 10 240 36 C 280 10 320 10 360 36 C 400 10 440 10 480 36 C 520 10 560 10 600 36 C 640 10 680 10 720 36 C 760 10 800 10 840 36 C 880 10 920 10 960 36 C 980 20 990 20 1000 36 Z" fill="rgba(255, 230, 240, 0.45)"/>
                </svg>
            </div>

            <div class="kb-footer-icons" aria-hidden="true">
                <!-- Winged Heart -->
                <span>
                    <svg width="36" height="20" viewBox="0 0 40 24" fill="none">
                        <path d="M12 14 C4 10 2 0 14 6 C10 10 10 14 12 14 Z" fill="#ffc2d6" stroke="#f0789d" stroke-width="1.2"/>
                        <path d="M28 14 C36 10 38 0 26 6 C30 10 30 14 28 14 Z" fill="#ffc2d6" stroke="#f0789d" stroke-width="1.2"/>
                        <path d="M20 20 C20 20 13 15 13 10 C13 7.5 15 6 17 6 C18.5 6 20 7.5 20 7.5 C20 7.5 21.5 6 23 6 C25 6 27 7.5 27 10 C27 15 20 20 20 20 Z" fill="#ed5287"/>
                    </svg>
                </span>
                <!-- Bow -->
                <span>
                    <svg width="28" height="18" viewBox="0 0 38 24" fill="none">
                        <path d="M19 12 C10 0 4 20 19 12 Z" fill="#fca4c0" stroke="#eb6793" stroke-width="1.5"/>
                        <path d="M19 12 C28 0 34 20 19 12 Z" fill="#fca4c0" stroke="#eb6793" stroke-width="1.5"/>
                        <circle cx="19" cy="12" r="5" fill="#f25f8f" stroke="#eb6793" stroke-width="1.2"/>
                    </svg>
                </span>
                <!-- Crescent Moon -->
                <span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#ffd475">
                        <path d="M12 2 A10 10 0 1 0 22 12 A8 8 0 0 1 12 2 Z"/>
                    </svg>
                </span>
            </div>

            <p class="kb-copyright">
                © Copyright 2026. <span class="pink">Kawaii blessings</span> All rights reserved.<br>
                webstore Powered by KeynoStore by KeynoTech <span class="heart">💕</span>
            </p>
        </footer>
    </div>

    @push('scripts')
        {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        const inputId = this.getAttribute('data-toggle-password');
                        const input = document.getElementById(inputId);

                        if (!input) return;

                        const isPassword = input.type === 'password';
                        input.type = isPassword ? 'text' : 'password';

                        this.innerHTML = isPassword
                            ? `<svg class="kb-eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12 C1 12 5 4 12 4 C19 4 23 12 23 12 C23 12 19 20 12 20 C5 20 1 12 1 12 Z"/>
                                <circle cx="12" cy="12" r="3"/>
                               </svg>`
                            : `<svg class="kb-eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12 C1 12 5 4 12 4 C19 4 23 12 23 12 C23 12 19 20 12 20 C5 20 1 12 1 12 Z"/>
                                <circle cx="12" cy="12" r="3"/>
                                <line x1="3" y1="21" x2="21" y2="3"/>
                               </svg>`;
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const page = document.querySelector('.kb-register-page');

                if (!page) {
                    return;
                }

                const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const finePointer = window.matchMedia('(pointer: fine)').matches;

                if (!reduceMotion && finePointer) {
                    let rafId = null;

                    page.addEventListener('pointermove', function (event) {
                        if (rafId) {
                            cancelAnimationFrame(rafId);
                        }

                        rafId = requestAnimationFrame(function () {
                            const rect = page.getBoundingClientRect();
                            const x = ((event.clientX - rect.left) / rect.width) - 0.5;
                            const y = ((event.clientY - rect.top) / rect.height) - 0.5;

                            page.style.setProperty('--kb-mouse-x', (x * 12).toFixed(2) + 'px');
                            page.style.setProperty('--kb-mouse-y', (y * 10).toFixed(2) + 'px');
                        });
                    });

                    page.addEventListener('pointerleave', function () {
                        page.style.setProperty('--kb-mouse-x', '0px');
                        page.style.setProperty('--kb-mouse-y', '0px');
                    });
                }

                if (!reduceMotion) {
                    document.querySelectorAll('.kb-sky-cloud').forEach(function (cloud, index) {
                        cloud.style.animationDelay = (-0.65 * index) + 's';
                    });

                    document.querySelectorAll('.kb-floating-symbol').forEach(function (symbol, index) {
                        symbol.style.animationDuration = (5.2 + (index % 4) * 0.65) + 's';
                    });
                }

                document.querySelectorAll('.kb-input').forEach(function (input) {
                    input.addEventListener('focus', function () {
                        const card = input.closest('.kb-form-card');

                        if (!card) {
                            return;
                        }

                        card.classList.remove('kb-field-active');
                        void card.offsetWidth;
                        card.classList.add('kb-field-active');
                    });
                });
            });
        </script>

    @endpush
</x-shop::layouts>
