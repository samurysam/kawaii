<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <link
            rel="preconnect"
            href="https://fonts.googleapis.com"
            crossorigin
        />

        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin
        />

        <link
            href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&family=DM+Serif+Display&display=swap"
            rel="stylesheet"
        />
    </head>

    <body style="margin:0; background: linear-gradient(135deg, #fff6fa 0%, #fad9e5 100%); font-family: 'Nunito Sans', 'Poppins', sans-serif; color: #5b3a45;">
        <div style="max-width: 680px; margin-left: auto; margin-right: auto; padding: 24px 12px;">
            <div style="padding: 30px; background: #ffffff; border: 1px solid #f4c7d6; border-radius: 28px; box-shadow: 0 8px 24px rgba(237, 110, 152, 0.08);">
                <!-- Email Header -->
                <div style="margin-bottom: 36px; padding: 22px; border-radius: 22px; background: linear-gradient(135deg, #ffffff 0%, #fff6fa 45%, #fad9e5 100%); text-align: center;">
                    <a href="{{ route('shop.home.index') }}">
                        @if ($logo = core()->getCurrentChannel()->logo_url)
                            <img
                                src="{{ $logo }}"
                                alt="{{ core()->getCurrentChannel()->logo_alt ?: config('app.name') }}"
                                style="height: 40px; width: 110px;"
                            />
                        @else
                            <img
                                src="{{ bagisto_asset('images/logo.svg', 'shop') }}"
                                alt="{{ config('app.name') }}"
                                width="131"
                                height="29"
                                style="width: 156px;height: 40px;"
                            />
                        @endif
                    </a>

                    <p style="margin: 14px 0 0; font-family: 'Fredoka', 'Baloo 2', cursive; font-size: 24px; line-height: 30px; color: #5b3a45;">
                        Kawaii Blessings
                    </p>

                    <p style="margin: 6px 0 0; font-size: 14px; line-height: 21px; color: #8a6772;">
                        Sweet updates from your pastel-premium gift store
                    </p>
                </div>

                <!-- Email Content -->
                {{ $slot }}

                <!-- Email Footer -->
                <p style="margin-top: 32px; font-size: 16px; color: #5b3a45; line-height: 24px;">
                    @lang('shop::app.emails.thanks', [
                        'link' => 'mailto:' . core()->getContactEmailDetails()['email'],
                        'email' => core()->getContactEmailDetails()['email'],
                        'style' => 'color: #ED6E98;'
                    ])
                </p>

                <p style="margin: 14px 0 0; font-size: 13px; line-height: 20px; color: #8a6772;">
                    Webstore powered by KeynoStore by KeynoTech
                </p>
            </div>
        </div>
    </body>
</html>
