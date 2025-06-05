<?php

declare(strict_types = 1);

return [
    App\Providers\AppServiceProvider::class,
    Modules\Customer\Providers\CustomerServiceProvider::class,
    Modules\Product\Providers\ProductServiceProvider::class,
    Modules\Order\Providers\OrderServiceProvider::class,
];
