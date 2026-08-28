<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.addresses.edit.edit')
        @lang('shop::app.customers.account.addresses.edit.title') 
    </x-slot>

    <!-- Sidebar Navigation -->
    <x-shop::layouts.account.navigation />

    <!-- Main Content Card -->
    <div class="kb-dash-main-card">
        <!-- Page Header -->
        <div class="kb-dash-card-head">
            <div class="kb-dash-card-head-left">
                <div class="kb-dash-card-icon-box">
                    <span>📍</span>
                </div>

                <div>
                    <h1 class="kb-dash-card-title">
                        @lang('shop::app.customers.account.addresses.edit.edit')
                        @lang('shop::app.customers.account.addresses.edit.title')
                    </h1>
                    <p class="kb-dash-card-subtitle">
                        Update your saved address details
                    </p>
                </div>
            </div>

            <a
                href="{{ route('shop.customers.account.addresses.index') }}"
                class="kb-dash-head-btn"
            >
                <span>&larr;</span>
                <span>Cancel</span>
            </a>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.address.edit.before', ['address' => $address]) !!}

        <!-- Customer Address edit Component-->
        <v-edit-customer-address>
            <!-- Address Shimmer -->
            <x-shop::shimmer.form.control-group :count="10" />
        </v-edit-customer-address>

        {!! view_render_event('bagisto.shop.customers.account.address.edit.after', ['address' => $address]) !!}
    </div>

    @push('scripts')
        <script
            type="text/x-template"
            id="v-edit-customer-address-template"
        >
            <!-- Edit Address Form -->
            <x-shop::form
                method="PUT"
                :action="route('shop.customers.account.addresses.update',  $address->id)"
            >
                {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.before', ['address' => $address]) !!}

                <!-- First Name & Last Name -->
                <div class="grid grid-cols-2 gap-4 max-md:grid-cols-1 mb-4">
                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                                @lang('shop::app.customers.account.addresses.edit.first-name')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                name="first_name"
                                rules="required"
                                class="!h-[48px] !px-4 w-full"
                                :value="old('first_name') ?? $address->first_name"
                                :label="trans('shop::app.customers.account.addresses.edit.first-name')"
                                :placeholder="trans('shop::app.customers.account.addresses.edit.first-name')"
                            />

                            <x-shop::form.control-group.error control-name="first_name" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.first_name.after', ['address' => $address]) !!}
                    </div>

                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                                @lang('shop::app.customers.account.addresses.edit.last-name')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                name="last_name"
                                rules="required"
                                class="!h-[48px] !px-4 w-full"
                                :value="old('last_name') ?? $address->last_name"
                                :label="trans('shop::app.customers.account.addresses.edit.last-name')"
                                :placeholder="trans('shop::app.customers.account.addresses.edit.last-name')"
                            />

                            <x-shop::form.control-group.error control-name="last_name" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.last_name.after', ['address' => $address]) !!}
                    </div>
                </div>

                <!-- Company Name & VAT ID -->
                <div class="grid grid-cols-2 gap-4 max-md:grid-cols-1 mb-4">
                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                                @lang('shop::app.customers.account.addresses.edit.company-name')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                name="company_name"
                                class="!h-[48px] !px-4 w-full"
                                :value="old('company_name') ?? $address->company_name"
                                :label="trans('shop::app.customers.account.addresses.edit.company-name')"
                                :placeholder="trans('shop::app.customers.account.addresses.edit.company-name')"
                            />

                            <x-shop::form.control-group.error control-name="company_name" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.company_name.after', ['address' => $address]) !!}
                    </div>

                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                                @lang('shop::app.customers.account.addresses.edit.vat-id')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                name="vat_id"
                                class="!h-[48px] !px-4 w-full"
                                :value="old('vat_id') ?? $address->vat_id"
                                :label="trans('shop::app.customers.account.addresses.edit.vat-id')"
                                :placeholder="trans('shop::app.customers.account.addresses.edit.vat-id')"
                            />

                            <x-shop::form.control-group.error control-name="vat_id" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.vat_id.after', ['address' => $address]) !!}
                    </div>
                </div>

                <!-- Email & Phone -->
                <div class="grid grid-cols-2 gap-4 max-md:grid-cols-1 mb-4">
                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                                @lang('Email')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="email"
                                name="email"
                                rules="required|email"
                                class="!h-[48px] !px-4 w-full"
                                :value="old('email') ?? $address->email"
                                :label="trans('Email')"
                                :placeholder="trans('Email')"
                            />

                            <x-shop::form.control-group.error control-name="email" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.email.after', ['address' => $address]) !!}
                    </div>

                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                                @lang('shop::app.customers.account.addresses.edit.phone')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                name="phone"
                                rules="required|phone"
                                class="!h-[48px] !px-4 w-full"
                                :value="old('phone') ?? $address->phone"
                                :label="trans('shop::app.customers.account.addresses.edit.phone')"
                                :placeholder="trans('shop::app.customers.account.addresses.edit.phone')"
                            />

                            <x-shop::form.control-group.error control-name="phone" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.phone.after', ['address' => $address]) !!}
                    </div>
                </div>

                <!-- Street Address -->
                <div class="mb-4">
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                            @lang('shop::app.customers.account.addresses.edit.street-address')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="address[]"
                            rules="required|address"
                            class="!h-[48px] !px-4 w-full"
                            :value="old('address') ? collect(old('address'))->first() : (collect($address->address)->first() ?? '')"
                            :label="trans('shop::app.customers.account.addresses.edit.street-address')"
                            :placeholder="trans('shop::app.customers.account.addresses.edit.street-address')"
                        />

                        <x-shop::form.control-group.error control-name="address[]" />
                    </x-shop::form.control-group>

                    @if (
                        core()->getConfigData('customer.address.information.street_lines')
                        && core()->getConfigData('customer.address.information.street_lines') > 1
                    )
                        @for ($i = 1; $i < core()->getConfigData('customer.address.information.street_lines'); $i++)
                            <x-shop::form.control-group.control
                                type="text"
                                name="address[{{ $i }}]"
                                class="!h-[48px] !px-4 mt-2 w-full"
                                :value="old('address') ? (collect(old('address'))[$i] ?? '') : (collect($address->address)[$i] ?? '')"
                                rules="address"
                                :label="trans('shop::app.customers.account.addresses.edit.street-address')"
                                :placeholder="trans('shop::app.customers.account.addresses.edit.street-address')"
                            />

                            <x-shop::form.control-group.error
                                class="mb-2"
                                name="address[{{ $i }}]"
                            />
                        @endfor
                    @endif

                    {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.street_address.after', ['address' => $address]) !!}
                </div>

                <!-- Country & State -->
                <div class="grid grid-cols-2 gap-4 max-md:grid-cols-1 mb-4">
                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d] {{ core()->isCountryRequired() ? 'required' : '' }}">
                                @lang('shop::app.customers.account.addresses.edit.country')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="select"
                                name="country"
                                class="!h-[48px] !px-4 w-full"
                                rules="{{ core()->isCountryRequired() ? 'required' : '' }}"
                                v-model="country"
                                :aria-label="trans('shop::app.customers.account.addresses.edit.country')"
                                :label="trans('shop::app.customers.account.addresses.edit.country')"
                            >
                                <option value="">
                                    @lang('shop::app.customers.account.addresses.edit.select-country')
                                </option>

                                @foreach (core()->countries() as $country)
                                    <option 
                                        {{ $country->code === $address->country ? 'selected' : '' }}  
                                        value="{{ $country->code }}"
                                    >
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </x-shop::form.control-group.control>

                            <x-shop::form.control-group.error control-name="country" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.country.after', ['address' => $address]) !!}
                    </div>

                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d] {{ core()->isStateRequired() ? 'required' : '' }}">
                                @lang('shop::app.customers.account.addresses.edit.state')
                            </x-shop::form.control-group.label>

                            <template v-if="haveStates()">
                                <x-shop::form.control-group.control
                                    type="select"
                                    name="state"
                                    id="state"
                                    class="!h-[48px] !px-4 w-full"
                                    rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                                    v-model="state"
                                    :label="trans('shop::app.customers.account.addresses.edit.state')"
                                    :placeholder="trans('shop::app.customers.account.addresses.edit.state')"
                                >
                                    <option 
                                        v-for='(state, index) in countryStates[country]'
                                        :value="state.code"
                                    >
                                        @{{ state.default_name }}
                                    </option>
                                </x-shop::form.control-group.control>
                            </template>

                            <template v-else>
                                <x-shop::form.control-group.control
                                    type="text"
                                    name="state"
                                    class="!h-[48px] !px-4 w-full"
                                    rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                                    :value="old('state') ?? $address->state"
                                    :label="trans('shop::app.customers.account.addresses.edit.state')"
                                    :placeholder="trans('shop::app.customers.account.addresses.edit.state')"
                                />
                            </template>

                            <x-shop::form.control-group.error control-name="state" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.state.after', ['address' => $address]) !!}
                    </div>
                </div>

                <!-- City & Postcode -->
                <div class="grid grid-cols-2 gap-4 max-md:grid-cols-1 mb-6">
                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d]">
                                @lang('shop::app.customers.account.addresses.edit.city')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                name="city"
                                rules="required"
                                class="!h-[48px] !px-4 w-full"
                                :value="old('city') ?? $address->city"
                                :label="trans('shop::app.customers.account.addresses.edit.city')"
                                :placeholder="trans('shop::app.customers.account.addresses.edit.city')"
                            />

                            <x-shop::form.control-group.error control-name="city" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.city.after', ['address' => $address]) !!}
                    </div>

                    <div>
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="font-['Plus_Jakarta_Sans'] text-[13px] font-bold text-[#3f2b2d] {{ core()->isPostCodeRequired() ? 'required' : '' }}">
                                @lang('shop::app.customers.account.addresses.edit.post-code')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                name="postcode"
                                class="!h-[48px] !px-4 w-full"
                                rules="{{ core()->isPostCodeRequired() ? 'required' : '' }}|postcode"
                                :value="old('postcode') ?? $address->postcode"
                                :label="trans('shop::app.customers.account.addresses.edit.post-code')"
                                :placeholder="trans('shop::app.customers.account.addresses.edit.post-code')"
                            />

                            <x-shop::form.control-group.error control-name="postcode" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.postcode.after', ['address' => $address]) !!}
                    </div>
                </div>

                <!-- Set As Default Toggle -->
                <div class="mb-6 flex select-none items-center gap-2 rounded-[16px] border border-[#f2d7df] bg-[#ffffff] p-4">
                    <input
                        type="checkbox"
                        name="default_address"
                        value="{{ $address->default_address }}"
                        id="default_address"
                        class="peer hidden cursor-pointer"
                        {{ $address->default_address ? 'checked' : '' }}
                    >

                    <label
                        class="icon-uncheck peer-checked:icon-check-box cursor-pointer text-2xl text-[#d95d86] peer-checked:text-[#d95d86]"
                        for="default_address"
                    >
                    </label>

                    <label 
                        class="block cursor-pointer select-none text-sm font-semibold text-[#3f2b2d]"
                        for="default_address"
                    >
                        ⭐ @lang('shop::app.customers.account.addresses.edit.set-as-default')
                    </label>
                </div>

                <button
                    type="submit"
                    class="kb-dash-head-btn !bg-gradient-to-r !from-[#f2628e] !to-[#d95d86] !text-white !border-transparent px-10 py-3.5 text-base shadow-lg max-md:w-full"
                >
                    <span>♥</span>
                    <span>@lang('shop::app.customers.account.addresses.edit.save')</span>
                </button>

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.after', ['address' => $address]) !!}
            </x-shop::form>
        </script>

        <script type="module">
            app.component('v-edit-customer-address', {
                template: '#v-edit-customer-address-template',

                data() {
                    return {
                        country: "{{ old('country') ?? $address->country }}",

                        state: "{{ old('state') ?? $address->state }}",

                        countryStates: @json(core()->groupedStatesByCountries()),
                    }
                },

                methods: {
                    haveStates() {
                        return !!this.countryStates[this.country]?.length;
                    },
                }
            });
        </script>
    @endpush
</x-shop::layouts.account>
