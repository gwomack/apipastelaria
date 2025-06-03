<?php

namespace Modules\Customer\Console\Commands;

use Illuminate\Console\Command;
use Modules\Customer\Models\Customer;

class GenerateApiKeyCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer:generate-api-key
        {customer? : The ID of the customer (optional)}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API key for customer. if customer not found, create a new one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('customer');

        $customer = $id ? Customer::find($id) : null;

        if (!$customer) {
            $customer = Customer::factory()->create();
        }

        $token = $customer->createToken(
            config('customer.token_name')
        );

        $this->info('API key generated successfully');
        $this->info('API key: ' . $token->plainTextToken);
    }
}
