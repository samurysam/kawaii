<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.users.sessions.title')
    </x-slot>

    <div class="flex min-h-[100vh] items-center justify-center px-4 py-10">
        <div class="flex w-full max-w-[520px] flex-col items-center gap-6">
            <!-- Logo -->            
            @if ($logo = core()->getConfigData('general.design.admin_logo.logo_image'))
                <img
                    class="h-10 w-[110px]"
                    src="{{ Storage::url($logo) }}"
                    alt="{{ config('app.name') }}"
                />
            @else
                <img
                    class="w-max" 
                    src="{{ bagisto_asset('images/logo.svg') }}"
                    alt="{{ config('app.name') }}"
                />
            @endif

            <div class="kb-admin-panel flex w-full min-w-[300px] flex-col overflow-hidden p-2">
                <!-- Login Form -->
                <x-admin::form :action="route('admin.session.store')">
                    <div class="rounded-[20px] bg-[linear-gradient(135deg,_#fff6fa_0%,_#fad9e5_100%)] px-5 py-5 text-center">
                        <p class="kb-admin-title text-3xl">
                            @lang('admin::app.users.sessions.title')
                        </p>

                        <p class="mt-2 text-sm text-[#8A6772]">
                            Kawaii Blessings admin access
                        </p>
                    </div>

                    <div class="px-3 pb-3 pt-4">
                        <div class="rounded-[20px] border border-[#F4C7D6] bg-white p-4">
                            <p class="mb-4 text-sm font-semibold text-[#5B3A45]">
                                Welcome back. Sign in to manage products, content, and storefront settings.
                            </p>

                            <div class="grid gap-4">
                                <!-- Email -->
                                <x-admin::form.control-group>
                                    <x-admin::form.control-group.label class="required">
                                        @lang('admin::app.users.sessions.email')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control 
                                        type="email" 
                                        class="w-full max-w-full" 
                                        id="email"
                                        name="email" 
                                        rules="required|email" 
                                        :label="trans('admin::app.users.sessions.email')"
                                        :placeholder="trans('admin::app.users.sessions.email')"
                                    />

                                    <x-admin::form.control-group.error control-name="email" />
                                </x-admin::form.control-group>

                                <!-- Password -->
                                <x-admin::form.control-group class="relative w-full">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('admin::app.users.sessions.password')
                                    </x-admin::form.control-group.label>
                        
                                    <x-admin::form.control-group.control 
                                        type="password" 
                                        class="w-full max-w-full ltr:pr-10 rtl:pl-10" 
                                        id="password"
                                        name="password" 
                                        rules="required|min:6" 
                                        :label="trans('admin::app.users.sessions.password')"
                                        :placeholder="trans('admin::app.users.sessions.password')"
                                    />
                        
                                    <span 
                                        class="icon-view absolute top-[42px] -translate-y-2/4 cursor-pointer text-2xl text-[#8A6772] ltr:right-2 rtl:left-2"
                                        onclick="switchVisibility()"
                                        id="visibilityIcon"
                                        role="presentation"
                                        tabindex="0"
                                    >
                                    </span>
                        
                                    <x-admin::form.control-group.error control-name="password" />
                                </x-admin::form.control-group>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-5 pb-5 pt-1">
                        <!-- Forgot Password Link -->
                        <a 
                            class="cursor-pointer text-xs font-semibold leading-6 text-[#ED6E98]"
                            href="{{ route('admin.forget_password.create') }}"
                        >
                            @lang('admin::app.users.sessions.forget-password-link')
                        </a>

                        <!-- Submit Button -->
                        <button
                            class="primary-button"
                            aria-label="{{ trans('admin::app.users.sessions.submit-btn')}}"
                        >
                            @lang('admin::app.users.sessions.submit-btn')
                        </button>
                    </div>
                </x-admin::form>
            </div>

            <!-- Powered By -->
            <div class="text-center text-sm font-normal text-[#8A6772]">
                @lang('admin::app.users.sessions.powered-by-description', [
                    'bagisto' => '<a class="text-blue-600 hover:underline" href="https://bagisto.com/en/">Bagisto</a>',
                    'webkul' => '<a class="text-blue-600 hover:underline" href="https://webkul.com/">Webkul</a>',
                ])
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function switchVisibility() {
                let passwordField = document.getElementById("password");
                let visibilityIcon = document.getElementById("visibilityIcon");

                passwordField.type = passwordField.type === "password" ? "text" : "password";
                visibilityIcon.classList.toggle("icon-view-close");
            }
        </script>
    @endpush
</x-admin::layouts.anonymous>
