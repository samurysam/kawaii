<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        QR Payments Dashboard (uTap by e&)
    </x-slot>

    <!-- Header -->
    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap mb-6">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <span>QR Payments</span>
                <span class="text-xs px-2.5 py-1 rounded-full font-bold bg-pink-100 text-pink-700 dark:bg-pink-900/40 dark:text-pink-300">
                    📱 Public / In-Store QR
                </span>
            </p>
            <p class="text-xs text-gray-500 mt-1">
                Monitor and manage all in-person and quick-pay transactions scanned via your store's QR code.
            </p>
        </div>

        <div class="flex items-center gap-x-2.5">
            <a
                href="{{ $publicPayUrl }}"
                target="_blank"
                class="secondary-button"
            >
                ↗ Test Live QR Page
            </a>

            <button
                type="button"
                class="secondary-button"
                onclick="navigator.clipboard.writeText('{{ $publicPayUrl }}'); this.innerText = 'Copied! 📋'; setTimeout(() => this.innerText = '📋 Copy Public URL', 2000);"
            >
                📋 Copy Public URL
            </button>
        </div>
    </div>

    <!-- Top Banner: Kawaii Branded QR Poster & Download Box -->
    <div class="box-shadow rounded-3xl bg-white dark:bg-gray-900 p-6 border border-pink-100 dark:border-gray-800 mb-8">
        <div class="flex items-center justify-between gap-8 max-lg:flex-col">
            <!-- Left Info -->
            <div class="flex-1 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold bg-pink-50 text-pink-600 border border-pink-200">
                    <span style="color:#d9a84f;">✦</span> Storefront & POS In-Person Payments
                </div>

                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight" style="font-family:'Fredoka',sans-serif;">
                    Your Official Store QR Code 💖
                </h2>

                <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed max-w-xl">
                    Share this branded QR code with customers or print it as an in-store counter standee. Customers can scan with their smartphone camera, enter any amount in AED, and pay securely via <strong>uTap by e& (Cards & Apple Pay)</strong> with instant email receipts.
                </p>

                <div class="flex items-center gap-3 pt-2 max-sm:flex-wrap">
                    <button
                        type="button"
                        id="downloadPngBtn"
                        onclick="downloadKawaiiQrCard()"
                        class="primary-button flex items-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold text-white shadow-md transition cursor-pointer"
                        style="background:linear-gradient(135deg, #f58aab, #ed5287);"
                    >
                        <span>⬇️</span>
                        <span>Download Kawaii QR Card (PNG)</span>
                    </button>

                    <button
                        type="button"
                        onclick="printKawaiiQrPoster()"
                        class="secondary-button flex items-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold transition cursor-pointer"
                    >
                        <span>🖨️</span>
                        <span>Print POS Counter Standee</span>
                    </button>
                </div>
            </div>

            <!-- Right: Kawaii Branded Poster Preview Card -->
            <div style="width: 280px; flex-shrink: 0; margin: 0 auto;">
                <div
                    id="kawaiiQrCardElement"
                    style="background: linear-gradient(145deg, #fff5f8 0%, #ffe3ed 100%); border: 2px solid #f6b8cc; border-radius: 24px; padding: 20px 16px; text-align: center; box-shadow: 0 10px 30px rgba(226, 116, 157, 0.18);"
                >
                    <!-- Sparkle top badge -->
                    <div style="display:inline-block; padding: 4px 12px; border-radius: 999px; font-size: 10px; font-weight: 800; color: #ed5287; background: #fff; border: 1px solid #f6ccd9; margin-bottom: 8px;">
                        ✨ Kawaii Blessings Quick Pay
                    </div>

                    <h3 style="font-size: 18px; font-weight: 800; color: #2b1f24; margin: 0 0 2px; font-family: 'Fredoka', sans-serif;">
                        Scan to Pay 💖
                    </h3>
                    <p style="font-size: 10.5px; color: #7a5061; font-weight: 600; margin: 0 0 12px;">
                        Instant UAE Checkout with uTap by e&
                    </p>

                    <!-- QR Box -->
                    <div style="background: #fff; padding: 10px; border-radius: 16px; border: 1px solid #f6ccd9; box-shadow: 0 4px 12px rgba(0,0,0,0.06); display: inline-block; margin-bottom: 10px;">
                        <img
                            id="kawaiiQrImg"
                            src="{{ $publicQrCodeUrl }}"
                            crossorigin="anonymous"
                            alt="Kawaii Quick Pay QR"
                            style="width: 170px; height: 170px; display: block; border-radius: 8px;"
                        />
                    </div>

                    <!-- Accepted Badges -->
                    <p style="font-size: 9.5px; font-weight: 700; color: #735460; text-transform: uppercase; margin: 0 0 2px; letter-spacing: 0.3px;">
                        💳 Cards • Apple Pay • Secure
                    </p>
                    <p style="font-size: 11px; font-weight: 800; color: #ed5287; font-family: monospace; margin: 0;">
                        kawaii.keynostore.com/pay
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Payments DataGrid Table -->
    <div class="mb-4">
        <h3 class="text-base font-bold text-gray-800 dark:text-white mb-3 flex items-center gap-2">
            <span>QR Transactions History</span>
            <span class="text-xs px-2 py-0.5 rounded-full font-bold bg-pink-100 text-pink-700 dark:bg-pink-900/40 dark:text-pink-300">
                Public / POS
            </span>
        </h3>
    </div>

    <x-admin::datagrid :src="route('admin.sales.qr_payments.index')" ref="datagrid" />

    @pushOnce('scripts')
        <script>
            // Download Kawaii QR Card as high-res PNG
            function downloadKawaiiQrCard() {
                const btn = document.getElementById('downloadPngBtn');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<span>⏳</span><span>Generating PNG...</span>';

                // Canvas drawing for standalone crisp PNG
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                
                // Set canvas size (High-Res 2x: 800x1080)
                canvas.width = 800;
                canvas.height = 1080;

                // 1. Draw background gradient
                const grad = ctx.createLinearGradient(0, 0, 800, 1080);
                grad.addColorStop(0, '#fff5f8');
                grad.addColorStop(0.5, '#ffe6f0');
                grad.addColorStop(1, '#ffd4e5');
                ctx.fillStyle = grad;
                ctx.roundRect(0, 0, 800, 1080, 48);
                ctx.fill();

                // 2. Draw border
                ctx.lineWidth = 8;
                ctx.strokeStyle = '#f6b8cc';
                ctx.stroke();

                // 3. Header badge
                ctx.fillStyle = '#ffffff';
                ctx.shadowColor = 'rgba(237, 82, 135, 0.15)';
                ctx.shadowBlur = 12;
                ctx.roundRect(230, 60, 340, 48, 24);
                ctx.fill();
                ctx.shadowBlur = 0;

                ctx.fillStyle = '#ed5287';
                ctx.font = 'bold 20px -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('✨ KAWAII BLESSINGS ✨', 400, 92);

                // 4. Main Title
                ctx.fillStyle = '#2b1f24';
                ctx.font = '900 52px "Fredoka", -apple-system, BlinkMacSystemFont, sans-serif';
                ctx.fillText('Scan to Pay 💖', 400, 185);

                // 5. Subtitle
                ctx.fillStyle = '#7a5061';
                ctx.font = '600 24px -apple-system, BlinkMacSystemFont, sans-serif';
                ctx.fillText('Instant & Secure UAE Quick-Pay', 400, 230);

                // 6. White QR Container Box
                ctx.fillStyle = '#ffffff';
                ctx.shadowColor = 'rgba(226, 116, 157, 0.25)';
                ctx.shadowBlur = 28;
                ctx.roundRect(140, 270, 520, 520, 36);
                ctx.fill();
                ctx.shadowBlur = 0;

                ctx.lineWidth = 4;
                ctx.strokeStyle = '#f8cfdc';
                ctx.stroke();

                // Draw QR Code Image into canvas
                const img = new Image();
                img.crossOrigin = 'anonymous';
                img.onload = function () {
                    ctx.drawImage(img, 180, 310, 440, 440);

                    // 7. Footer details
                    ctx.fillStyle = '#4a333d';
                    ctx.font = 'bold 24px -apple-system, BlinkMacSystemFont, sans-serif';
                    ctx.fillText('Accepted: Cards • Apple Pay • uTap by e&', 400, 850);

                    // URL Box
                    ctx.fillStyle = '#ffffff';
                    ctx.roundRect(160, 890, 480, 60, 20);
                    ctx.fill();
                    ctx.lineWidth = 2;
                    ctx.strokeStyle = '#f3b8cc';
                    ctx.stroke();

                    ctx.fillStyle = '#ed5287';
                    ctx.font = 'bold 26px monospace';
                    ctx.fillText('kawaii.keynostore.com/pay', 400, 930);

                    // Note
                    ctx.fillStyle = '#946e7f';
                    ctx.font = '500 18px -apple-system, BlinkMacSystemFont, sans-serif';
                    ctx.fillText('Delivering Kawaii Joy Across UAE ✦ Support: hello@kawaiiblessings.com', 400, 1010);

                    // Trigger Download
                    const link = document.createElement('a');
                    link.download = 'Kawaii_Blessings_Store_QR_Pay.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();

                    btn.innerHTML = originalText;
                };

                img.onerror = function () {
                    const link = document.createElement('a');
                    link.download = 'Kawaii_QR_Code.png';
                    link.href = '{{ $publicQrCodeUrl }}';
                    link.target = '_blank';
                    link.click();
                    btn.innerHTML = originalText;
                };

                img.src = '{{ $publicQrCodeUrl }}';
            }

            // Print counter standee
            function printKawaiiQrPoster() {
                const printContent = document.getElementById('kawaiiQrCardElement').outerHTML;
                const win = window.open('', '_blank');
                win.document.write(`
                    <html>
                    <head>
                        <title>Kawaii Blessings — POS Counter QR Standee</title>
                        <style>
                            body { margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: sans-serif; background: #fff; }
                            @media print { body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } }
                        </style>
                    </head>
                    <body>
                        <div style="width:340px;transform:scale(1.3);transform-origin:center;">
                            ${printContent}
                        </div>
                    </body>
                    </html>
                `);
                win.document.close();
                setTimeout(() => {
                    win.print();
                }, 500);
            }
        </script>
    @endPushOnce
</x-admin::layouts>
