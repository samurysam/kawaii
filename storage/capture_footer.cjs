const { chromium } = require('/Users/samerkhan/Downloads/kawaiiblessings/my-bagisto-store/packages/Webkul/Shop/node_modules/playwright');

(async () => {
    try {
        const browser = await chromium.launch({
            executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
            headless: true
        });
        
        // Desktop Viewport (1440px wide to match render sample)
        const context = await browser.newContext({
            viewport: { width: 1440, height: 1200 }
        });
        const page = await context.newPage();

        await context.addCookies([
            { name: 'cookie-consent', value: '1', domain: 'localhost', path: '/' }
        ]);

        console.log('Navigating to Home page...');
        await page.goto('http://localhost:8000/', { waitUntil: 'networkidle' });

        await page.evaluate(() => {
            // Scroll to bottom
            window.scrollTo(0, document.body.scrollHeight);
            // Hide sticky headers to prevent overlap
            const stickyHeaders = document.querySelectorAll('header, .sticky, [class*="sticky"]');
            stickyHeaders.forEach(el => { el.style.display = 'none'; });
        });

        await page.waitForTimeout(500);

        const footer = await page.$('.kb-footer');
        if (footer) {
            console.log('Capturing footer element...');
            await footer.screenshot({ path: 'storage/footer_rendered.png' });
        } else {
            console.log('Footer element not found, capturing full page...');
            await page.screenshot({ path: 'storage/footer_rendered.png', fullPage: true });
        }

        // Mobile Viewport
        const mobileContext = await browser.newContext({
            viewport: { width: 390, height: 844 },
            userAgent: 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1'
        });
        const mobilePage = await mobileContext.newPage();
        await mobileContext.addCookies([
            { name: 'cookie-consent', value: '1', domain: 'localhost', path: '/' }
        ]);

        console.log('Navigating to Home on mobile...');
        await mobilePage.goto('http://localhost:8000/', { waitUntil: 'networkidle' });
        
        await mobilePage.evaluate(() => {
            window.scrollTo(0, document.body.scrollHeight);
            const stickyHeaders = document.querySelectorAll('header, .sticky, [class*="sticky"]');
            stickyHeaders.forEach(el => { el.style.display = 'none'; });
        });

        await mobilePage.waitForTimeout(500);

        const mobileFooter = await mobilePage.$('.kb-footer');
        if (mobileFooter) {
            console.log('Capturing mobile footer element...');
            await mobileFooter.screenshot({ path: 'storage/footer_mobile_rendered.png' });
        }

        console.log('All footer screenshots completed!');
        await browser.close();
    } catch (e) {
        console.error('Error:', e);
    }
})();
