<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExpiresTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expires:tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expire_days = setting('invoices', 'expires_days') ?? 30;
        $invoices = \Modules\Invoice\Entities\Invoice::where('created_at', '<=', now()->subDays($expire_days))->take(10)->cursor();
        foreach($invoices as $invoice)
        {
            if( !is_null($plugin = $invoice->plugin) )
            {
                $plugin->update(['payment_status', 'expired']);
            }
        }
    }
}
