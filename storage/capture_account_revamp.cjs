const { chromium } = require('/Users/samerkhan/Downloads/kawaiiblessings/my-bagisto-store/packages/Webkul/Shop/node_modules/playwright');

(async () => {
    try {
        const browser = await chromium.launch({
            executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
            headless: true
        });
        
        // 1. Desktop Context (1440px)
        const context = await browser.newContext({
            viewport: { width: 1440, height: 960 },
            deviceScaleFactor: 2
        });
        const page = await context.newPage();

        console.log('Logging in on desktop...');
        await page.goto('http://localhost:8000/customer/login', { waitUntil: 'load' });
        
        await page.fill('input[name="email"]', 'samer@keynoverse.tech');
        await page.fill('input[name="password"]', 'Password123!');
        
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'load', timeout: 10000 }),
            page.click('button[type="submit"]')
        ]);

        await context.addCookies([
            { name: 'cookie-consent', value: '1', domain: 'localhost', path: '/' }
        ]);

        console.log('Capturing Desktop Profile...');
        await page.goto('http://localhost:8000/customer/account/profile', { waitUntil: 'networkidle' });
        await page.screenshot({ path: '/Users/samerkhan/.gemini/antigravity/brain/56590f9a-c87f-4f03-a9ae-df9c54e31d4d/account_desktop_profile_revamp.png', fullPage: true });

        console.log('Capturing Desktop Addresses...');
        await page.goto('http://localhost:8000/customer/account/addresses', { waitUntil: 'networkidle' });
        await page.screenshot({ path: '/Users/samerkhan/.gemini/antigravity/brain/56590f9a-c87f-4f03-a9ae-df9c54e31d4d/account_desktop_addresses_revamp.png', fullPage: true });

        console.log('Capturing Desktop Orders...');
        await page.goto('http://localhost:8000/customer/account/orders', { waitUntil: 'networkidle' });
        await page.screenshot({ path: '/Users/samerkhan/.gemini/antigravity/brain/56590f9a-c87f-4f03-a9ae-df9c54e31d4d/account_desktop_orders_revamp.png', fullPage: true });

        console.log('Capturing Desktop Wishlist...');
        await page.goto('http://localhost:8000/customer/account/wishlist', { waitUntil: 'networkidle' });
        await page.screenshot({ path: '/Users/samerkhan/.gemini/antigravity/brain/56590f9a-c87f-4f03-a9ae-df9c54e31d4d/account_desktop_wishlist_revamp.png', fullPage: true });

        // 2. Mobile Context (390px)
        const mobileContext = await browser.newContext({
            viewport: { width: 390, height: 844 },
            deviceScaleFactor: 2,
            userAgent: 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1'
        });
        const mobilePage = await mobileContext.newPage();
        await mobileContext.addCookies([
            { name: 'cookie-consent', value: '1', domain: 'localhost', path: '/' }
        ]);

        console.log('Logging in on mobile...');
        await mobilePage.goto('http://localhost:8000/customer/login', { waitUntil: 'load' });
        await mobilePage.fill('input[name="email"]', 'samer@keynoverse.tech');
        await mobilePage.fill('input[name="password"]', 'Password123!');
        await Promise.all([
            mobilePage.waitForNavigation({ waitUntil: 'load', timeout: 10000 }),
            mobilePage.click('button[type="submit"]')
        ]);

        console.log('Capturing Mobile Profile...');
        await mobilePage.goto('http://localhost:8000/customer/account/profile', { waitUntil: 'networkidle' });
        await mobilePage.screenshot({ path: '/Users/samerkhan/.gemini/antigravity/brain/56590f9a-c87f-4f03-a9ae-df9c54e31d4d/account_mobile_profile_revamp.png', fullPage: true });

        console.log('Capturing Mobile Addresses...');
        await mobilePage.goto('http://localhost:8000/customer/account/addresses', { waitUntil: 'networkidle' });
        await mobilePage.screenshot({ path: '/Users/samerkhan/.gemini/antigravity/brain/56590f9a-c87f-4f03-a9ae-df9c54e31d4d/account_mobile_addresses_revamp.png', fullPage: true });

        console.log('All screenshots captured successfully!');
        await browser.close();
    } catch (e) {
        console.error('Error:', e);
    }
})();
