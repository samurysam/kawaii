{!! view_render_event('marketplace.seller.account.sign_up.form.agreement.before') !!}

<v-customer-rma-return-policy></v-customer-rma-return-policy>

{!! view_render_event('marketplace.seller.account.sign_up.form.agreement.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-customer-rma-return-policy-template"
    >
        <div class="mb-4">
            <v-field
                type="checkbox" 
                name="agreement" 
                rules="required" 
                v-slot="{ field, errors }" 
                value="1"
            >
                <label class="relative inline-flex cursor-pointer items-start gap-2.5">
                    <input
                        type="checkbox"
                        class="peer sr-only"
                        id="agreement"
                        name="agreement"
                        value="1"
                        v-bind="field"
                    />

                    <span
                        class="icon-uncheck peer-checked:icon-check-box cursor-pointer text-2xl leading-tight peer-checked:text-[#ed6e98]"
                    >
                    </span>

                    <span class="block">
                        <span class="text-xs font-semibold text-[#846671]">
                            @lang('shop::app.customers.account.rma.terms.terms')
                        </span>
                        
                        <a 
                            href="javascript:void(0);" 
                            class="ml-1 text-xs font-bold text-[#ed6e98] hover:text-[#d83d73] hover:underline"
                            @click.prevent="$refs.agreementModel.open()"
                        >
                            @lang('shop::app.customers.account.rma.terms.read')
                        </a>
                    </span>
                </label>

                <span 
                    v-if="errors[0]" 
                    class="mt-1 block text-xs font-semibold text-rose-500"
                    v-text="errors[0]"
                >
                </span>
            </v-field>
        </div>

        <!-- Agreement modal -->
        <x-shop::modal ref="agreementModel">
            <!-- Modal Header -->
            <x-slot:header>
                <h2 class="font-['Fredoka'] text-xl font-bold text-[#382229]">
                    @lang('installer::app.seeders.cms.pages.terms-conditions.title')
                </h2>
            </x-slot>

            <!-- Modal Content -->
            <x-slot:content>
                <div 
                    class="overflow-y-auto rounded-2xl border-[1.5px] border-[#fae8ef] bg-[#fffbfd] p-5" 
                    style="min-height: 400px; max-height: 500px;"
                >
                    <div class="prose prose-sm max-w-none text-xs font-semibold leading-relaxed text-[#5b3a45]">
                        {{ core()->getConfigData('sales.rma.setting.return_policy') }}
                    </div>
                </div>
            </x-slot>
        </x-shop::modal>
    </script>

    <script type="module">
        app.component('v-customer-rma-return-policy', {
            template: '#v-customer-rma-return-policy-template',
        })
    </script>
@endPushOnce