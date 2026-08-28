<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.profile.edit.edit-profile')
    </x-slot>

    <!-- Sidebar Navigation -->
    <x-shop::layouts.account.navigation />

    <!-- Main Content Card -->
    <div class="kb-dash-main-card">
        <!-- Page Header -->
        <div class="kb-dash-card-head">
            <div class="kb-dash-card-head-left">
                <div class="kb-dash-card-icon-box">
                    <span>👤</span>
                </div>

                <div>
                    <h1 class="kb-dash-card-title">
                        @lang('shop::app.customers.account.profile.edit.edit-profile')
                    </h1>
                    <p class="kb-dash-card-subtitle">
                        Update your personal info, avatar, and security settings
                    </p>
                </div>
            </div>

            <a
                href="{{ route('shop.customers.account.profile.index') }}"
                class="kb-dash-head-btn"
            >
                <span>&larr;</span>
                <span>Cancel</span>
            </a>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.profile.edit.before', ['customer' => $customer]) !!}

        <!-- Profile Edit Form -->
        <x-shop::form
            :action="route('shop.customers.account.profile.update')"
            enctype="multipart/form-data"
        >
            {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.before', ['customer' => $customer]) !!}

            <!-- Avatar Image Uploader -->
            <div class="mb-6 rounded-[20px] border border-[#f2d7df] bg-[#fffdfd] p-5">
                <p class="font-['Playfair_Display'] text-[15px] font-bold text-[#3f2b2d] mb-3">
                    Profile Avatar 🌸
                </p>
                <x-shop::form.control-group class="!mb-0">
                    <x-shop::form.control-group.control
                        type="image"
                        class="mb-0 rounded-2xl !p-0 text-gray-700"
                        name="image[]"
                        :label="trans('Image')"
                        :is-multiple="false"
                        accepted-types="image/*"
                        :src="$customer->image_url"
                    />

                    <x-shop::form.control-group.error control-name="image[]" />
                </x-shop::form.control-group>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.image.after') !!}

            <!-- Personal Information Section -->
            <div class="kb-dash-sec-head">
                <h2 class="kb-dash-sec-title">
                    <span>🌾</span>
                    <span>Basic Details</span>
                </h2>
            </div>

            <div class="grid grid-cols-2 gap-4 max-md:grid-cols-1 mb-4">
                <!-- First Name -->
                <div>
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                            @lang('shop::app.customers.account.profile.edit.first-name')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="first_name"
                            rules="required"
                            class="!h-[48px] !px-4 w-full"
                            :value="old('first_name') ?? $customer->first_name"
                            :label="trans('shop::app.customers.account.profile.edit.first-name')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.first-name')"
                        />

                        <x-shop::form.control-group.error control-name="first_name" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.first_name.after') !!}
                </div>

                <!-- Last Name -->
                <div>
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                            @lang('shop::app.customers.account.profile.edit.last-name')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="last_name"
                            rules="required"
                            class="!h-[48px] !px-4 w-full"
                            :value="old('last_name') ?? $customer->last_name"
                            :label="trans('shop::app.customers.account.profile.edit.last-name')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.last-name')"
                        />

                        <x-shop::form.control-group.error control-name="last_name" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.last_name.after') !!}
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="grid grid-cols-2 gap-4 max-md:grid-cols-1 mb-4">
                <!-- Email -->
                <div>
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                            @lang('shop::app.customers.account.profile.edit.email')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="email"
                            name="email"
                            rules="required|email"
                            class="!h-[48px] !px-4 w-full"
                            :value="old('email') ?? $customer->email"
                            :label="trans('shop::app.customers.account.profile.edit.email')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.email')"
                        />

                        <x-shop::form.control-group.error control-name="email" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.email.after') !!}
                </div>

                <!-- Phone -->
                <div>
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                            @lang('shop::app.customers.account.profile.edit.phone')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="phone"
                            rules="phone"
                            class="!h-[48px] !px-4 w-full"
                            :value="old('phone') ?? $customer->phone"
                            :label="trans('shop::app.customers.account.profile.edit.phone')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.phone')"
                        />

                        <x-shop::form.control-group.error control-name="phone" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.phone.after') !!}
                </div>
            </div>

            <!-- Demographics Section -->
            <div class="grid grid-cols-2 gap-4 max-md:grid-cols-1 mb-6">
                <!-- Gender -->
                <div>
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                            @lang('shop::app.customers.account.profile.edit.gender')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="select"
                            class="!h-[48px] !px-4 mb-3 w-full"
                            name="gender"
                            rules="required"
                            :value="old('gender') ?? $customer->gender"
                            :aria-label="trans('shop::app.customers.account.profile.edit.select-gender')"
                            :label="trans('shop::app.customers.account.profile.edit.gender')"
                        >
                            <option value="Other">
                                @lang('shop::app.customers.account.profile.edit.other')
                            </option>

                            <option value="Male">
                                @lang('shop::app.customers.account.profile.edit.male')
                            </option>

                            <option value="Female">
                                @lang('shop::app.customers.account.profile.edit.female')
                            </option>
                        </x-shop::form.control-group.control>

                        <x-shop::form.control-group.error control-name="gender" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.gender.after') !!}
                </div>

                <!-- DOB -->
                <div>
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                            @lang('shop::app.customers.account.profile.edit.dob')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="date"
                            name="date_of_birth"
                            class="!h-[48px] !px-4 w-full"
                            :value="old('date_of_birth') ?? $customer->date_of_birth"
                            :label="trans('shop::app.customers.account.profile.edit.dob')"
                            :placeholder="trans('shop::app.customers.account.profile.edit.dob')"
                        />

                        <x-shop::form.control-group.error control-name="date_of_birth" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.date_of_birth.after') !!}
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="mb-6 rounded-[22px] border-[1.5px] border-[#f2d7df] bg-[#fffafc] p-6">
                <div class="mb-4">
                    <h3 class="font-['Playfair_Display'] text-[17px] font-bold text-[#3f2b2d]">
                        🔒 Security &amp; Password
                    </h3>
                    <p class="text-xs font-semibold text-[#7c6770]">
                        Leave blank if you do not want to change your password.
                    </p>
                </div>

                <!-- Current Password -->
                <x-shop::form.control-group class="mb-4">
                    <x-shop::form.control-group.label class="font-['Plus_Jakarta_Sans'] text-[13px] font-semibold text-[#3f2b2d]">
                        @lang('shop::app.customers.account.profile.edit.current-password')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="password"
                        name="current_password"
                        value=""
                        class="!h-[48px] !px-4 w-full"
                        :label="trans('shop::app.customers.account.profile.edit.current-password')"
                        :placeholder="trans('shop::app.customers.account.profile.edit.current-password')"
                    />

                    <x-shop::form.control-group.error control-name="current_password" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.old_password.after') !!}

                <div class="grid grid-cols-2 gap-4 max-md:grid-cols-1">
                    <!-- New Password -->
                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="font-['Plus_Jakarta_Sans'] text-[13px] font-semibold text-[#3f2b2d]">
                                @lang('shop::app.customers.account.profile.edit.new-password')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="password"
                                name="new_password"
                                value=""
                                class="!h-[48px] !px-4 w-full"
                                :label="trans('shop::app.customers.account.profile.edit.new-password')"
                                :placeholder="trans('shop::app.customers.account.profile.edit.new-password')"
                            />

                            <x-shop::form.control-group.error control-name="new_password" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.new_password.after') !!}
                    </div>

                    <!-- New Password Confirmation -->
                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="font-['Plus_Jakarta_Sans'] text-[13px] font-semibold text-[#3f2b2d]">
                                @lang('shop::app.customers.account.profile.edit.confirm-password')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="password"
                                name="new_password_confirmation"
                                rules="confirmed:@new_password"
                                value=""
                                class="!h-[48px] !px-4 w-full"
                                :label="trans('shop::app.customers.account.profile.edit.confirm-password')"
                                :placeholder="trans('shop::app.customers.account.profile.edit.confirm-password')"
                            />

                            <x-shop::form.control-group.error control-name="new_password_confirmation" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.new_password_confirmation.after') !!}
                    </div>
                </div>
            </div>

            <!-- Newsletter Subscription Toggle -->
            <div class="mb-6 flex select-none items-center gap-2 rounded-[16px] border border-[#f2d7df] bg-[#ffffff] p-4">
                <input
                    type="checkbox"
                    name="subscribed_to_news_letter"
                    id="is-subscribed"
                    class="peer hidden"
                    @checked($customer->subscribed_to_news_letter)
                />

                <label
                    class="icon-uncheck peer-checked:icon-check-box cursor-pointer text-2xl text-[#d95d86] peer-checked:text-[#d95d86]"
                    for="is-subscribed"
                ></label>

                <label
                    class="cursor-pointer select-none text-sm font-semibold text-[#3f2b2d]"
                    for="is-subscribed"
                >
                    💌 @lang('shop::app.customers.account.profile.edit.subscribe-to-newsletter')
                </label>
            </div>

            <div class="flex items-center gap-4">
                <button
                    type="submit"
                    class="kb-dash-head-btn !bg-gradient-to-r !from-[#f2628e] !to-[#d95d86] !text-white !border-transparent px-10 py-3.5 text-base shadow-lg max-md:w-full"
                >
                    <span>♥</span>
                    <span>@lang('shop::app.customers.account.profile.edit.save')</span>
                </button>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.edit_form_controls.after', ['customer' => $customer]) !!}

        </x-shop::form>

        {!! view_render_event('bagisto.shop.customers.account.profile.edit.after', ['customer' => $customer]) !!}
    </div>
</x-shop::layouts.account>
