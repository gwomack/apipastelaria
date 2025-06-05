<?php

use Modules\Customer\Models\Customer;

// Test: generates API key for existing customer
it('generates api key for existing customer', function () {
    $customer = Customer::factory()->create();

    $this->artisan('customer:generate-api-key', ['customer' => $customer->id])
        ->expectsOutput('API key generated successfully')
        ->expectsOutputToContain('API key:')
        ->assertExitCode(0);
});

// Test: creates customer and generates API key if not found
it('creates customer and generates api key if not found', function () {
    expect(Customer::count())->toBe(0);

    $this->artisan('customer:generate-api-key')
        ->expectsOutput('API key generated successfully')
        ->expectsOutputToContain('API key:')
        ->assertExitCode(0);

    expect(Customer::count())->toBe(1);
});
