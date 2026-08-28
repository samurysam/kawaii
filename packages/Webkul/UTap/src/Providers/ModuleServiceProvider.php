<?php

namespace Webkul\UTap\Providers;

use Webkul\Core\Providers\CoreModuleServiceProvider;
use Webkul\UTap\Models\PaymentLink;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    protected $models = [
        PaymentLink::class,
    ];
}
