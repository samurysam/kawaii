const { chromium } = require('/Users/samerkhan/Downloads/kawaiiblessings/my-bagisto-store/packages/Webkul/Shop/node_modules/playwright');

(async () => {
    try {
        const browser = await chromium.launch({
            executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
            headless: true
        });
        
        // Desktop
        const context = await browser.newContext({
            viewport: { width: 1280, height: 900 }
        });
        const page = await context.newPage();

        console.log('Navigating to login...');
        await page.goto('http://localhost:8000/customer/login', { waitUntil: 'load' });
        
        await page.fill('input[name="email"]', 'samer@keynoverse.tech');
        await page.fill('input[name="password"]', 'Password123!');
        
        console.log('Submitting login form...');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'load', timeout: 10000 }),
            page.click('button[type="submit"]')
        ]);

        await context.addCookies([
            { name: 'cookie-consent', value: '1', domain: 'localhost', path: '/' }
        ]);

        console.log('Capturing Desktop Addresses with Items...');
        await page.goto('http://localhost:8000/customer/account/addresses', { waitUntil: 'networkidle' });
        await page.screenshot({ path: 'storage/account_addresses_populated.png', fullPage: true });

        console.log('Capturing Desktop Wishlist with Items...');
        await page.goto('http://localhost:8000/customer/account/wishlist', { waitUntil: 'networkidle' });
        await page.screenshot({ path: 'storage/account_wishlist_populated.png', fullPage: true });

        // Mobile context
        const mobileContext = await browser.newContext({
            viewport: { width: 390, height: 844 },
            userAgent: 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1'
        });
        const mobilePage = await mobileContext.newPage();
        await mobileContext.addCookies([
            { name: 'cookie-consent', value: '1', domain: 'localhost', path: '/' }
        ]);

        console.log('Navigating to login on mobile...');
        await mobilePage.goto('http://localhost:8000/customer/login', { waitUntil: 'load' });
        await mobilePage.fill('input[name="email"]', 'samer@keynoverse.tech');
        await mobilePage.fill('input[name="password"]', 'Password123!');
        await Promise.all([
            mobilePage.waitForNavigation({ waitUntil: 'load', timeout: 10000 }),
            mobilePage.click('button[type="submit"]')
        ]);

        console.log('Capturing Mobile Dashboard...');
        await mobilePage.goto('http://localhost:8000/customer/account', { waitUntil: 'networkidle' });
        await mobilePage.screenshot({ path: 'storage/account_mobile_dashboard_new.png', fullPage: true });

        console.log('Capturing Mobile Addresses with Items...');
        await mobilePage.goto('http://localhost:8000/customer/account/addresses', { waitUntil: 'networkidle' });
        await mobilePage.screenshot({ path: 'storage/account_mobile_addresses_populated.png', fullPage: true });

        console.log('Capturing Mobile Wishlist with Items...');
        await mobilePage.goto('http://localhost:8000/customer/account/wishlist', { waitUntil: 'networkidle' });
        await mobilePage.screenshot({ path: 'storage/account_mobile_wishlist_populated.png', fullPage: true });

        console.log('All screenshots completed!');
        await browser.close();
    } catch (e) {
        console.error('Error:', e);
    }
})();
